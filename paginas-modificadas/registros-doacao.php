<?php

session_start();
include('./connection.php');
require('fpdf/fpdf.php');

if(!isset($_SESSION['id_usuario'])) header('location: index.php');

$header = ['Doador', 'Receptor', 'Projeto Social', 'Data', 'Valor', 'Confirmado em', 'Comprovante'];
$data = [];

$query_s_doacoes = 'SELECT U.nome_usuario as nome, ONG.nome_ong as ong, PROJ.nome_projeto as projeto, D.data_doacao, D.quantia_doacao as valor, D.data_confirmacao, C.arquivo_comprovante AS comprovante FROM tbdoacao as D 
INNER JOIN tbcomprovantes as C
ON D.id_comprovante_recebimento = C.id_comprovante
INNER JOIN tbusuario as U 
ON D.id_doador_doacao = U.id_usuario 
INNER JOIN tbprojeto as PROJ 
ON D.id_projeto_doacao = PROJ.id_projeto
INNER JOIN tbperfil_ong as ONG 
ON PROJ.id_ong_projeto = ONG.id_perfil_ong
WHERE D.id_doador_doacao = '. $_SESSION['id_usuario'] .' AND D.status = 1';
$result_s = mysqli_query($connection, $query_s_doacoes);
if(!$result_s){
    die('Erro ao buscar doações do usuário: ' . mysqli_error($connection));
}

while($reg = mysqli_fetch_assoc($result_s)){
    array_push($data, ['nome' => $reg['nome'], 'ong' => $reg['ong'], 'projeto' => $reg['projeto'], 'data_doacao' => $reg['data_doacao'], 'valor' => $reg['valor'], 'data_confirmacao' => $reg['data_confirmacao'], 'comprovante' => $reg['comprovante']]);
}

class PDF extends FPDF{
   
    function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link=''){
    $txt = iconv(mb_detect_encoding($txt, mb_detect_order(), true), "UTF-8", $txt);

    //Output a cell
    $k=$this->k;
    if($this->y+$h>$this->PageBreakTrigger && !$this->InHeader && !$this->InFooter && $this->AcceptPageBreak())
    {
        //Automatic page break
        $x=$this->x;
        $ws=$this->ws;
        if($ws>0)
        {
            $this->ws=0;
            $this->_out('0 Tw');
        }
        $this->AddPage($this->CurOrientation,$this->CurPageSize);
        $this->x=$x;
        if($ws>0)
        {
            $this->ws=$ws;
            $this->_out(sprintf('%.3F Tw',$ws*$k));
        }
    }
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $s='';
// begin change Cell function
    if($fill || $border>0)
    {
        if($fill)
            $op=($border>0) ? 'B' : 'f';
        else
            $op='S';
        if ($border>1) {
            $s=sprintf('q %.2F w %.2F %.2F %.2F %.2F re %s Q ',$border,
                $this->x*$k,($this->h-$this->y)*$k,$w*$k,-$h*$k,$op);
        }
        else
            $s=sprintf('%.2F %.2F %.2F %.2F re %s ',$this->x*$k,($this->h-$this->y)*$k,$w*$k,-$h*$k,$op);
    }
    if(is_string($border))
    {
        $x=$this->x;
        $y=$this->y;
        if(is_int(strpos($border,'L')))
            $s.=sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-$y)*$k,$x*$k,($this->h-($y+$h))*$k);
        else if(is_int(strpos($border,'l')))
            $s.=sprintf('q 2 w %.2F %.2F m %.2F %.2F l S Q ',$x*$k,($this->h-$y)*$k,$x*$k,($this->h-($y+$h))*$k);
            
        if(is_int(strpos($border,'T')))
            $s.=sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-$y)*$k);
        else if(is_int(strpos($border,'t')))
            $s.=sprintf('q 2 w %.2F %.2F m %.2F %.2F l S Q ',$x*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-$y)*$k);
        
        if(is_int(strpos($border,'R')))
            $s.=sprintf('%.2F %.2F m %.2F %.2F l S ',($x+$w)*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
        else if(is_int(strpos($border,'r')))
            $s.=sprintf('q 2 w %.2F %.2F m %.2F %.2F l S Q ',($x+$w)*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
        
        if(is_int(strpos($border,'B')))
            $s.=sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-($y+$h))*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
        else if(is_int(strpos($border,'b')))
            $s.=sprintf('q 2 w %.2F %.2F m %.2F %.2F l S Q ',$x*$k,($this->h-($y+$h))*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
    }
    if (trim($txt)!='') {
        $cr=substr_count($txt,"\n");
        if ($cr>0) { // Multi line
            $txts = explode("\n", $txt);
            $lines = count($txts);
            for($l=0;$l<$lines;$l++) {
                $txt=$txts[$l];
                $w_txt=$this->GetStringWidth($txt);
                if($align=='R')
                    $dx=$w-$w_txt-$this->cMargin;
                elseif($align=='C')
                    $dx=($w-$w_txt)/2;
                else
                    $dx=$this->cMargin;

                $txt=str_replace(')','\\)',str_replace('(','\\(',str_replace('\\','\\\\',$txt)));
                if($this->ColorFlag)
                    $s.='q '.$this->TextColor.' ';
                $s.=sprintf('BT %.2F %.2F Td (%s) Tj ET ',
                    ($this->x+$dx)*$k,
                    ($this->h-($this->y+.5*$h+(.7+$l-$lines/2)*$this->FontSize))*$k,
                    $txt);
                if($this->underline)
                    $s.=' '.$this->_dounderline($this->x+$dx,$this->y+.5*$h+.3*$this->FontSize,$txt);
                if($this->ColorFlag)
                    $s.=' Q ';
                if($link)
                    $this->Link($this->x+$dx,$this->y+.5*$h-.5*$this->FontSize,$w_txt,$this->FontSize,$link);
            }
        }
        else { // Single line
            $w_txt=$this->GetStringWidth($txt);
            $Tz=100;
            if ($w_txt>$w-2*$this->cMargin) { // Need compression
                $Tz=($w-2*$this->cMargin)/$w_txt*100;
                $w_txt=$w-2*$this->cMargin;
            }
            if($align=='R')
                $dx=$w-$w_txt-$this->cMargin;
            elseif($align=='C')
                $dx=($w-$w_txt)/2;
            else
                $dx=$this->cMargin;
            $txt=str_replace(')','\\)',str_replace('(','\\(',str_replace('\\','\\\\',$txt)));
            if($this->ColorFlag)
                $s.='q '.$this->TextColor.' ';
            $s.=sprintf('q BT %.2F %.2F Td %.2F Tz (%s) Tj ET Q ',
                        ($this->x+$dx)*$k,
                        ($this->h-($this->y+.5*$h+.3*$this->FontSize))*$k,
                        $Tz,$txt);
            if($this->underline)
                $s.=' '.$this->_dounderline($this->x+$dx,$this->y+.5*$h+.3*$this->FontSize,$txt);
            if($this->ColorFlag)
                $s.=' Q ';
            if($link)
                $this->Link($this->x+$dx,$this->y+.5*$h-.5*$this->FontSize,$w_txt,$this->FontSize,$link);
        }
    }
    // end change Cell function
        if($s)
            $this->_out($s);
        $this->lasth=$h;
        if($ln>0)
        {
            //Go to next line
            $this->y+=$h;
            if($ln==1)
                $this->x=$this->lMargin;
        }
        else
            $this->x+=$w;
    }

    function Header(){
        $this->SetXY(1, 1);
        $this->Image('./logos/logo_completa.png', 1, 1, 4.7, 3);
        $this->Ln(0.5);

        $this->SetXY(11, 0.5);
        $this->SetFont('Arial','B',12);
        $this->Write(1.5,'Do.Nation | Todos os direitos reservados');
        $this->Ln(0.5);
        $this->SetXY(14.9, 1);
        $this->SetFont('Arial','B',10);
        $this->Write(1.5,'CNPJ: 32.884.645/0001-20');
        $this->Ln(4);
    }

    function ImprovedTable($header, $data){
        $this->SetXY(5.5 , 4);
        $this->SetFont('Arial','B',12);
        $this->Write(1.5,'Comprovante de doações do usuário - Do.Nation');
        $this->Ln(2);


        // Cores e line width
        $this->SetFillColor(255,0,0); //cor vem aqui
        $this->SetTextColor(0, 0, 0);
        $this->SetDrawColor(0,0,0);
        $this->SetLineWidth(0.05);
        $this->SetFont('','B', 10);

        // Column widths
        $w = array(2.75, 2.75, 2.75, 2.75, 2.75, 2.75, 2.75);

        // Header
        for($i=0;$i<count($header);$i++){
            $this->Cell($w[$i],1,$header[$i],1,0,'C');
        }
        $this->Ln();

        // Dados da tabela
        $fill = false;
        foreach($data as $doacao){
            if(strlen($doacao['nome']) > 17) {
                $nameTrimmed = '';
                $name_fragments = explode(' ', $doacao['nome']);

                for($i = 0; $i < count($name_fragments); $i++){
                    $nameTrimmed .= $name_fragments[$i];

                    if($i%2 !== 0) $nameTrimmed .= '\n';
                    else continue;
                }

                $doacao['nome'] = $nameTrimmed;     
            }

            $this->Cell($w[0],2,$doacao['nome'],'LR',0,'C',$fill);
            $this->Cell($w[1],2,$doacao['ong'],'LR',0,'C',$fill);
            $this->Cell($w[2],2,$doacao['projeto'],'LR',0,'C',$fill);
            $this->Cell($w[3],2,$doacao['data_doacao'],'LR',0,'C',$fill);
            $this->Cell($w[4],2,$doacao['valor'],'LR',0,'C',$fill);
            $this->Cell($w[5],2,$doacao['data_confirmacao'],'LR',0,'C',$fill);

            $this->SetTextColor(6, 69, 173);
            $this->SetFont('','B', 7);
            $this->Cell($w[6],2,'Link do comprovante','LR',0,'C',$fill, 'http://localhost/donation101/comprovantes/download.php?document='.$doacao['comprovante']);
            /*Reset Color*/ 
            $this->SetTextColor(0, 0, 0);
            $this->SetFont('','B', 10);
            $this->Ln(); 
            /*$fill = !$fill;*/
        }
        // Closing line
        $this->Cell(array_sum($w),0,'','T');
    }

    function Footer(){
        $this->SetFont('Arial','',10);
        $this->SetXY(5.5,-2);
        $this->Write(1.5,'Copyright 2021 Donation Ltda. - Todos os direitos reservados');
        $this->SetXY(9.5,-1.5);
        $this->Write(1.5,'Página '.$this->PageNo().' de {total}');
    }
}
$pdf=new PDF('P','cm','A4');
$pdf->AliasNbPages('{total}');
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->ImprovedTable($header, $data);

$pdf->Output();
?>