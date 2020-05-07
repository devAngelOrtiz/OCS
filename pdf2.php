<?php
    /* incluimos primeramente el archivo que contiene la clase fpdf */
    include ('fpdf/fpdf.php');
    $marca= $_GET['productos'];
    $cliente= $_GET['nombre'];
    $filtro= $_GET['filtro'];
    //$fechai= $_GET['fechai'];
    //$fechaf= $_GET['fechaf'];

    // Cabecera para solucionar el problema de los acentos y las ñ
    header("Content-Type: text/html; charset=iso-8859-1 ");

    class PDF extends FPDF
    {
        var $B;
        var $I;
        var $U;
        var $HREF;
        
        //Funciones para crear el PDF
        function PDF($orientation='P', $unit='mm', $size='A4')
        {
            // Llama al constructor de la clase padre
            $this->FPDF($orientation,$unit,$size);
            // Iniciación de variables
            $this->B = 0;
            $this->I = 0;
            $this->U = 0;
            $this->HREF = '';
        }

        //Función para escribir en código HTML y que se detecten las etiquetas
        function WriteHTML($html)
        {
            // Intérprete de HTML
            $html = str_replace("\n",' ',$html);
            $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
            foreach($a as $i=>$e)
            {
                if($i%2==0)
                {
                    // Text
                    if($this->HREF)
                        $this->PutLink($this->HREF,$e);
                    else
                        $this->Write(5,$e);
                }
                else
                {
                    // Etiqueta
                    if($e[0]=='/')
                        $this->CloseTag(strtoupper(substr($e,1)));
                    else
                    {
                        // Extraer atributos
                        $a2 = explode(' ',$e);
                        $tag = strtoupper(array_shift($a2));
                        $attr = array();
                        foreach($a2 as $v)
                        {
                            if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                                $attr[strtoupper($a3[1])] = $a3[2];
                        }
                        $this->OpenTag($tag,$attr);
                    }
                }
            }
        }

        function OpenTag($tag, $attr)
        {
            // Etiqueta de apertura
            if($tag=='B' || $tag=='I' || $tag=='U')
                $this->SetStyle($tag,true);
            if($tag=='A')
                $this->HREF = $attr['HREF'];
            if($tag=='BR')
                $this->Ln(5);
        }

        function CloseTag($tag)
        {
            // Etiqueta de cierre
            if($tag=='B' || $tag=='I' || $tag=='U')
                $this->SetStyle($tag,false);
            if($tag=='A')
                $this->HREF = '';
        }

        function SetStyle($tag, $enable)
        {
            // Modificar estilo y escoger la fuente correspondiente
            $this->$tag += ($enable ? 1 : -1);
            $style = '';
            foreach(array('B', 'I', 'U') as $s)
            {
                if($this->$s>0)
                    $style .= $s;
            }
            $this->SetFont('',$style);
        }

        function PutLink($URL, $txt)
        {
            // Escribir un hiper-enlace
            $this->SetTextColor(0,0,255);
            $this->SetStyle('U',true);
            $this->Write(5,$txt,$URL);
            $this->SetStyle('U',false);
            $this->SetTextColor(0);
        }

        // Cabecera de página
        function Header()
        {
            // Logo de la cabecera del PDF
            $this->Image('log.jpg',8,8, 30);

        }

        // Pie de página
        function Footer()
        {
            // Posición: a 1,5 cm del final
            $this->SetY(-20);
            // Arial italic 8
            $this->SetFont('Arial','',8);
            // Número de página
            $this->Cell(0,10, $this->PageNo(),0,0,'C');
        }

        function TablaSimple($header, $datos)
        {
            $this->SetFillColor(44, 62, 80);
            $this->SetTextColor(255);
            $this->SetDrawColor(0,0,0);
            $this->SetFont('','B');
            //Cabecera

            for($i=0;$i<count($header);$i++)
            {
                if($i== 0)
                    $this->Cell(100,7,$header[$i],0,0,'L',1);
                else
                    $this->Cell(40,7,$header[$i],0,0,'L',1);
            }
            $this->Ln();

            $num= count($header);
            //Restauración de colores y fuentes
            $this->SetFillColor(223, 227, 232);
            $this->SetTextColor(0);
            $this->SetFont('');
            //Datos

            $salto=0;
            $color= true;
            for($i=0;$i<count($datos);$i++)
            {
                if($color == true)
                {
                    $this->SetFillColor(255, 255, 255);
                    if($i % $num == 0) 
                        $this->Cell(100,7,$datos[$i],0,0,'L',1);
                    else
                        $this->Cell(40,7,$datos[$i],0,0,'L',1);
                    $salto++;
                    if($salto == $num)
                    {    
                        $this->Ln();
                        $salto= 0;
                        $color= false;
                    }
                }
                else
                {
                    $this->SetFillColor(223, 227, 232);
                        if($i % $num == 0) 
                        $this->Cell(100,7,$datos[$i],0,0,'L',1);
                    else
                        $this->Cell(40,7,$datos[$i],0,0,'L',1);
                        $salto++;
                        if($salto == $num)
                        {    
                            $this->Ln();
                            $salto= 0;
                            $color= true;
                        }
                }
            }
               
        }
    }

    $client=new SoapClient(null,array('uri'=>'http://localhost/','location'=>'http://localhost/p/OCS/consola/web/webservice.php'));
    $idCliente= $client->id_cliente($cliente);

    if($filtro == 1 || $filtro == 2)
    {
        $datos= $client->consulta_mas($idCliente[0], $marca);
    }
    if($filtro == 3)
    {
        $datos= $client->consulta_menos($id_cliente[0], $marca);
    }

    $nombre= "<b>Descripción del reporte</b>";
    $descripcion= "<b>Marca: </b>".$marca;
    $cliente= "<b>Cliente: </b>".$cliente;
    $img= "imagenes/log.jpg";
    $header=array('Nombre','Marca', 'Precio');

    //Antes de pasar los datos al PDF, hay que pasar las variables por la función html_entity_decode para decodificar los caracteres especiales, los acentos y las ñ 
    // Siempre y cuando los datos extraídos de la BD sean UTF8 (no lo probe con otra codificación)

    $nombre = html_entity_decode($nombre);
    $descripcion = html_entity_decode($descripcion);
    $cliente = html_entity_decode($cliente);


    //Creamos una nueva instancia de la clase
    $pdf = new PDF();

    //Añádimos la primera página
    $pdf->AddPage();
    $pdf->SetFont('Helvetica','',20);
    $pdf->Ln(12);
    $pdf->Line(10, 30, 200, 30);
    $pdf->SetFontSize(17);
    $pdf->SetTextColor(44, 62, 80);
    $pdf->WriteHTML("Online Computer Shop");

    $pdf->SetTextColor(0);
    $pdf->SetLeftMargin(155);
    $pdf->SetFontSize(14);
    $pdf->Ln(-15);
    $pdf->WriteHTML("<br><br><b>Fecha:</b> ".date("d/m/Y", time()-25200));
    $pdf->WriteHTML("<br><b>Hora:</b> ".date("H:i:s", time()-25200)."\n\n");
    $pdf->SetLeftMargin(10);
    $pdf->Ln(13);
    // Otra parte importante, luego de pasar las variables por la función html_entity_decode, para que se vean bien los acentos y las ñ, hay que pasarlas por otra 
    // función que es utf8_decode
    $pdf->SetFontSize(14);
    $pdf->WriteHTML(utf8_decode($nombre));
    $pdf->WriteHTML("<br><br>");
    $pdf->WriteHTML(utf8_decode($cliente));
    $pdf->WriteHTML("<br>");
    $pdf->WriteHTML(utf8_decode($descripcion));
    //La función WriteHTML es la que creamos anteriormente para que lea las etiquetas html como <br>, <b>, <i>, <p>, etc.

    $pdf->Line(10,59, 200, 59);

    $pdf->WriteHTML("<br>");
    $pdf->Ln(25);
    $pdf->SetFontSize(10);
    $pdf->SetLeftMargin(15);
    $pdf->TablaSimple($header, $datos);

    if(empty($datos))
    {
        $pdf->SetFontSize(18);
        $mensaje= "<br><br>No se pudo generar el reporte porque no hay datos con esos filtros";
        $mensaje = html_entity_decode($mensaje);
        $pdf->WriteHTML(utf8_decode($mensaje));
    }
    $pdf->SetLeftMargin(10);
    //$pdf->Image($img, 55, 70, 100, 80);
    $pdf->Ln(-28);
    $pdf->SetLeftMargin(43);
    $pdf->Line(40, 270, 170, 270);
    $pdf->SetY(-26);
    $pdf->WriteHTML("Reporte generado por Online Computer Shop. Todos los derechos reservados");

    //Lo mismo que en la variable anterior, decodificamos la variable $html para que el texto se vea correctamente con los acentos y las ñ correspondientes.
    $pdf->SetLeftMargin(10);
    //Con OutPut hacemos que se visualice el PDF que acabamos de crear
    $pdf->OutPut();
?>