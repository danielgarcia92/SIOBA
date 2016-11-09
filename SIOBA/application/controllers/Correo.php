<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

header('Content-Type: text/html; charset=utf-8');
class Correo extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->database('default');
        $this->load->model('Correo_model');
        $this->load->library('session');
        $this->load->helper(array('url'));
    }

    public function index() {
        redirect('LoginCalificador');
    }

    public function enviarCorreo() {
        $asunto = "Sistema de observación en el aula";
        $nombreArchivo = "sioba_".$_POST['tipo'].".pdf";
        $archivo = "./sioba_".$_POST['tipo'].".pdf";
        $tamanoArchivo = filesize($archivo);
        $abrir = fopen($archivo, "r");
        $contenido = fread($abrir, $tamanoArchivo);
        fclose($abrir);
        $contenido = chunk_split(base64_encode($contenido));
        $cifrar = md5(uniqid(time()));

        $cabecera = "From: SIOBA <gerencia.aplicaciones@udem.edu>\r\n";
        $cabecera .= "MIME-Version: 1.0\r\n";
        $cabecera .= "Content-Type: multipart/mixed; boundary=\"".$cifrar."\"\r\n\r\n";

        $datosCorreo = $this->Correo_model->datosCorreo($_POST['folio']);

        if ($datosCorreo['longitud'] == 2) {
            if ($_POST['tipo'] == 'A') {
                $mensaje = "";
                $mensaje .= "El sistema de observación en el aula SIOBA de la Universidad de Monterrey, informa que el profesor ";
                $mensaje .= $datosCorreo['resultados'][2]->profesorNombre;
                $mensaje .= " ha realizado con éxito su autoevaluación sobre el curso ";
                $mensaje .= $datosCorreo['resultados'][2]->clave .' '. $datosCorreo['resultados'][2]->cursoNombre;
                $mensaje .= " correspondiente al periodo " . $datosCorreo['resultados'][2]->periodoDescripcion;
                $mensaje .= ". Adjunto a este correo podrá encontrar su autoevaluación y la observación realizada por el profesor observador ";
                $mensaje .= $datosCorreo['resultados'][2]->observadorNombre;
                $mensaje .= ", registrada en el sistema en la fecha ";
                $mensaje .= $datosCorreo['resultados'][2]->fechaIngreso;
                $mensaje .= ". Si usted no ha sido quien generó esta autoevaluación, por favor comunicarse con su jefe de departamento. Muchas gracias.";
                $receptor = $datosCorreo['resultados'][2]->profesorCorreo;

                $nmensaje = "This is a multi-part message in MIME format.\n\n";
                $nmensaje .= "--{$cifrar}\r\n" . "Content-Type: text/html; charset=\"iso-8859-1\"\n";
                $nmensaje .= "Content-Transfer-Encoding: 7bit\n\n" . $mensaje . "\n\n";
                $nmensaje .= "--{$cifrar}\n";

                $file = 'sioba_A.pdf';
                $filename = $file;
                $data = file_get_contents('sioba_A.pdf');
                $data = chunk_split(base64_encode($data));
                $nmensaje .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"sioba_A.pdf\"\n";
                $nmensaje .= "Content-Disposition: attachment;\n" . " filename=\"sioba_A.pdf\"\n";
                $nmensaje .= "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
                $nmensaje .= "--{$cifrar}\n";

                $file = 'sioba_O.pdf';
                 $filename = $file;
                $data = file_get_contents('sioba_O.pdf');
                $data = chunk_split(base64_encode($data));
                $nmensaje .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"sioba_O.pdf\"\n";
                $nmensaje .= "Content-Disposition: attachment;\n" . " filename=\"sioba_O.pdf\"\n";
                $nmensaje .= "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
                $nmensaje .= "--{$cifrar}\n";
                
                $correo = mail($receptor,$asunto,$nmensaje,$cabecera);

                if ($correo == true)
                    $datos['exito'] = true;
                else
                    $datos['exito'] = false;

            } else {
                $mensajeA = "";
                $mensajeA = $mensajeA . "El sistema de observación en el aula SIOBA de la Universidad de Monterrey, informa que el profesor ";
                $mensajeA = $mensajeA . $datosCorreo['resultados'][2]->profesorNombre;
                $mensajeA = $mensajeA . " ha sido evaluado satisfactoriamente por el profesor ";
                $mensajeA = $mensajeA . $datosCorreo['resultados'][2]->observadorNombre;
                $mensajeA = $mensajeA . " sobre el curso ";
                $mensajeA = $mensajeA . $datosCorreo['resultados'][2]->clave .' '. $datosCorreo['resultados'][2]->cursoNombre;
                $mensajeA = $mensajeA . " correspondiente al periodo " . $datosCorreo['resultados'][2]->periodoDescripcion;
                $mensajeA = $mensajeA . ". Adjunto a este correo podrá encontrar la observación registrada en el sistema en la fecha ";
                $mensajeA = $mensajeA . $datosCorreo['resultados'][2]->fechaIngreso;
                $receptorA = $datosCorreo['resultados'][2]->profesorCorreo;

                $nmensajeA = "This is a multi-part message in MIME format.\n\n";
                $nmensajeA .= "--{$cifrar}\r\n" . "Content-Type: text/html; charset=\"iso-8859-1\"\n";
                $nmensajeA .= "Content-Transfer-Encoding: 7bit\n\n" . $mensajeA . "\n\n"; 
                $nmensajeA .= "--{$cifrar}\n";

                $file = 'sioba_A.pdf';
                $filename = $file;
                $data = file_get_contents('sioba_A.pdf');
                $data = chunk_split(base64_encode($data));
                $nmensajeA .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"sioba_A.pdf\"\n";
                $nmensajeA .= "Content-Disposition: attachment;\n" . " filename=\"sioba_A.pdf\"\n";
                $nmensajeA .= "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
                $nmensajeA .= "--{$cifrar}\n";

                $file = 'sioba_O.pdf';
                $filename = $file;
                $data = file_get_contents('sioba_O.pdf');
                $data = chunk_split(base64_encode($data));
                $nmensajeA .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"sioba_O.pdf\"\n";
                $nmensajeA .= "Content-Disposition: attachment;\n" . " filename=\"sioba_O.pdf\"\n";
                $nmensajeA .= "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
                $nmensajeA .= "--{$cifrar}\n";

                $mensajeO = "";
                $mensajeO = $mensajeO . "El sistema de observación en el aula SIOBA de la Universidad de Monterrey, informa que el profesor ";
                $mensajeO = $mensajeO . $datosCorreo['resultados'][2]->observadorNombre;
                $mensajeO = $mensajeO . " ha realizado con éxito la observación sobre el curso ";
                $mensajeO = $mensajeO . $datosCorreo['resultados'][2]->clave .' '. $datosCorreo['resultados'][2]->cursoNombre;
                $mensajeO = $mensajeO . ", impartido por el profesor ";
                $mensajeO = $mensajeO . $datosCorreo['resultados'][2]->profesorNombre;
                $mensajeO = $mensajeO . " correspondiente al periodo " . $datosCorreo['resultados'][2]->periodoDescripcion;
                $mensajeO = $mensajeO . ". Adjunto a este correo podrá encontrar la observación registrada en el sistema en la fecha ";
                $mensajeO = $mensajeO . $datosCorreo['resultados'][2]->fechaIngreso;
                $mensajeO = $mensajeO . ". Si usted no ha sido quien generó esta observación, por favor comunicarse con su jefe de departamento. Muchas gracias.";
                $receptorO = $datosCorreo['resultados'][2]->observadorCorreo;

                $nmensajeO = "--".$cifrar."\r\n";
                $nmensajeO .= "Content-type:text/plain; charset=iso-8859-1\r\n";
                $nmensajeO .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
                $nmensajeO .= $mensajeO."\r\n\r\n";
                $nmensajeO .= "--".$cifrar."\r\n";
                $nmensajeO .= "Content-Type: application/octet-stream; name=\"".$nombreArchivo."\"\r\n";
                $nmensajeO .= "Content-Transfer-Encoding: base64\r\n";
                $nmensajeO .= "Content-Disposition: attachment; filename=\"".$nombreArchivo."\"\r\n\r\n";
                $nmensajeO .= $contenido."\r\n\r\n";
                $nmensajeO .= "--".$cifrar."--";

                $correoA = mail($receptorA,$asunto,$nmensajeA,$cabecera);
                $correoO = mail($receptorO,$asunto,$nmensajeO,$cabecera);

                if ($correoA == true && $correoO == true)
                    $datos['exito'] = true;
                else
                    $datos['exito'] = false;
            }

        print_r(json_encode($datos));

        } else {
            if ( $_POST['tipo'] == 'A' ) {
                $mensaje = "";
                $mensaje = $mensaje . "El sistema de observación en el aula SIOBA de la Universidad de Monterrey, informa que el profesor ";
                $mensaje = $mensaje . $datosCorreo['resultados'][1]->profesorNombre;
                $mensaje = $mensaje . " ha realizado con éxito su autoevaluación sobre el curso ";
                $mensaje = $mensaje . $datosCorreo['resultados'][1]->clave .' '. $datosCorreo['resultados'][1]->cursoNombre;
                $mensaje = $mensaje . " correspondiente al periodo " . $datosCorreo['resultados'][1]->periodoDescripcion;
                $mensaje = $mensaje . ". Dicha autoevaluación se registró en el sistema en la fecha ";
                $mensaje = $mensaje . $datosCorreo['resultados'][1]->fechaIngreso;
                $mensaje = $mensaje . ". Si usted no ha sido quien generó esta autoevaluación, por favor comunicarse con su jefe de departamento. Muchas gracias.";
                $receptor = $datosCorreo['resultados'][1]->profesorCorreo;

                $nmensaje = "--".$cifrar."\r\n";
                $nmensaje .= "Content-type:text/plain; charset=iso-8859-1\r\n";
                $nmensaje .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
                $nmensaje .= $mensaje."\r\n\r\n";

                $correo = mail($receptor,$asunto,$nmensaje,$cabecera);
                if ($correo == true)
                    $datos['exito'] = true;
                else
                    $datos['exito'] = false;
            } else {
                $mensajeA = "";
                $mensajeA = $mensajeA . "El sistema de observación en el aula SIOBA de la Universidad de Monterrey, informa que el profesor ";
                $mensajeA = $mensajeA . $datosCorreo['resultados'][1]->observadorNombre;
                $mensajeA = $mensajeA . " reportó satisfactoriamente la observación sobre el curso ";
                $mensajeA = $mensajeA . $datosCorreo['resultados'][1]->clave .' '. $datosCorreo['resultados'][1]->cursoNombre;
                $mensajeA = $mensajeA . ", impartido por el profesor ";
                $mensajeA = $mensajeA . $datosCorreo['resultados'][1]->profesorNombre;
                $mensajeA = $mensajeA . ". Dicha observación se registró en el sistema en la fecha ";
                $mensajeA = $mensajeA . $datosCorreo['resultados'][1]->fechaIngreso;
                $mensajeA = $mensajeA . " correspondiente al periodo " . $datosCorreo['resultados'][1]->periodoDescripcion;
                $mensajeA = $mensajeA . ". Se le informa que a partir de la hora de recepción de este correo cuenta con 48 horas para registrar su autoevaluación en el sistema. Muchas gracias.";
                $receptorA = $datosCorreo['resultados'][1]->profesorCorreo;

                $nmensajeA = "--".$cifrar."\r\n";
                $nmensajeA .= "Content-type:text/plain; charset=iso-8859-1\r\n";
                $nmensajeA .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
                $nmensajeA .= $mensajeA."\r\n\r\n";

                $mensajeO = "";
                $mensajeO = $mensajeO . "El sistema de observación en el aula SIOBA de la Universidad de Monterrey, informa que el profesor ";
                $mensajeO = $mensajeO . $datosCorreo['resultados'][1]->observadorNombre;
                $mensajeO = $mensajeO . " ha realizado con éxito la observación sobre el curso ";
                $mensajeO = $mensajeO . $datosCorreo['resultados'][1]->clave .' '. $datosCorreo['resultados'][1]->cursoNombre;
                $mensajeO = $mensajeO . ", impartido por el profesor ";
                $mensajeO = $mensajeO . $datosCorreo['resultados'][1]->profesorNombre;
                $mensajeO = $mensajeO . " correspondiente al periodo " . $datosCorreo['resultados'][1]->periodoDescripcion;
                $mensajeO = $mensajeO . ". Adjunto a este correo podrá encontrar la observación registrada en el sistema en la fecha ";
                $mensajeO = $mensajeO . $datosCorreo['resultados'][1]->fechaIngreso;
                $mensajeO = $mensajeO . ". Si usted no ha sido quien generó esta observación, por favor comunicarse con su jefe de departamento. Muchas gracias.";
                $receptorO = $datosCorreo['resultados'][1]->observadorCorreo;

                $nmensajeO = "--".$cifrar."\r\n";
                $nmensajeO .= "Content-type:text/plain; charset=iso-8859-1\r\n";
                $nmensajeO .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
                $nmensajeO .= $mensajeO."\r\n\r\n";
                $nmensajeO .= "--".$cifrar."\r\n";
                $nmensajeO .= "Content-Type: application/octet-stream; name=\"".$nombreArchivo."\"\r\n";
                $nmensajeO .= "Content-Transfer-Encoding: base64\r\n";
                $nmensajeO .= "Content-Disposition: attachment; filename=\"".$nombreArchivo."\"\r\n\r\n";
                $nmensajeO .= $contenido."\r\n\r\n";
                $nmensajeO .= "--".$cifrar."--";

                $correoA = mail($receptorA,$asunto,$nmensajeA,$cabecera);
                $correoO = mail($receptorO,$asunto,$nmensajeO,$cabecera);

                if ($correoA == true && $correoO == true)
                    $datos['exito'] = true;
                else
                    $datos['exito'] = false;
            }
        
        print_r(json_encode($datos));

        }

    }

}

?>
