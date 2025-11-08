<?php
session_start();

require '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $conn = $db->getConnection();

    if ($conn) {
        try {
            $conn->beginTransaction();

            if (isset($_FILES['workerimg']) && $_FILES['workerimg']['error'] === UPLOAD_ERR_OK) {
                $dir = "../../resource/workers/";

                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }

                $info_img = pathinfo($_FILES['workerimg']['name']);
                $extension = strtolower($info_img['extension']);

                // Validar el tipo de archivo usando el tipo MIME
                $mime_type = mime_content_type($_FILES['workerimg']['tmp_name']);
                $permitidos = [
                    'image/jpeg' => 'jpg',
                    'image/png' => 'png',
                    'image/webp' => 'webp',
                ];

                if (!isset($permitidos[$mime_type])) {
                    throw new Exception("Formato de imagen no permitido. Use JPG, JPEG, PNG o WEBP.");
                }

                $workercode = $_POST['workercode'];
                $nombre_archivo = $workercode . '.' . $permitidos[$mime_type];
                $ruta_archivo = $dir . $nombre_archivo;

                if (!move_uploaded_file($_FILES['workerimg']['tmp_name'], $ruta_archivo)) {
                    throw new Exception("Error al guardar la imagen.");
                }

                if ($mime_type !== 'image/webp') {
                    $ruta_webp = $dir . $workercode . '.webp';

                    // Cargar la imagen seg煤n su tipo
                    if ($mime_type === 'image/jpeg') {
                        $imageResource = imagecreatefromjpeg($ruta_archivo);
                    } elseif ($mime_type === 'image/png') {
                        $imageResource = imagecreatefrompng($ruta_archivo);

                        // Convertir la imagen indexada a truecolor si es necesario
                        if (imageistruecolor($imageResource) === false) {
                            $truecolorImage = imagecreatetruecolor(imagesx($imageResource), imagesy($imageResource));
                            imagecopy($truecolorImage, $imageResource, 0, 0, 0, 0, imagesx($imageResource), imagesy($imageResource));
                            imagedestroy($imageResource); // Liberar la memoria de la imagen original
                            $imageResource = $truecolorImage; // Usar la imagen truecolor
                        }
                    }

                    // Guardar la imagen como WebP
                    if ($imageResource && imagewebp($imageResource, $ruta_webp, 80)) {
                        imagedestroy($imageResource); // Liberar la memoria
                        unlink($ruta_archivo); // Eliminar la imagen original
                        $ruta_archivo = $ruta_webp;
                        $extension = 'webp';
                    } else {
                        throw new Exception("Error al convertir la imagen a WebP.");
                    }
                }

                $workerimg = "resource/workers/" . $workercode . '.' . $extension;
            } else {
                $workerimg = null;
            }

            // Insertar en la tabla worker
            $workercode = $conn->quote($_POST['workercode']);
            $workername1 = $conn->quote($_POST['workername1']);
            $workername2 = $conn->quote($_POST['workername2']);
            $workerlastname1 = $conn->quote($_POST['workerlastname1']);
            $workerlastname2 = $conn->quote($_POST['workerlastname2']);
            $workerhousbandname = $conn->quote($_POST['workerhousbandname']);
            $workerbirthdate = $conn->quote($_POST['workerbirthdate']);
            $workertypedoc = $conn->quote($_POST['workertypedoc']);
            $workerdoccity = $conn->quote($_POST['workerdoccity']);
            $workerdocnumber = $conn->quote($_POST['workerdocnumber']);
            $workersecurenum = $conn->quote($_POST['workersecurenum']);
            $workercuanum = $conn->quote($_POST['workercuanum']);
            $workercity = $conn->quote($_POST['workercity']);
            $workeremail = $conn->quote($_POST['workeremail']);
            $workerphone1 = $conn->quote($_POST['workerphone1']);
            $workerphone2 = $conn->quote($_POST['workerphone2']);
            $img = $conn->quote($workerimg);
            $codearea = $conn->quote($_POST['codearea']);
            $codeoccupation = $conn->quote($_POST['codeoccupation']);
            $codesection = $conn->quote($_POST['codesection']);
            $workeraddress = $conn->quote($_POST['workeraddress']);
            $workertypedoc = $conn->quote($_POST['workertypedoc']);
            $workernationality = $conn->quote($_POST['workernationality']);
            $workersex = $conn->quote($_POST['workersex']);
            $workernit = $conn->quote($_POST['workernit']);
            $workercivilstatust = $conn->quote($_POST['workercivilstatus']);
            $accountMain = $conn->quote($_POST['accountMain']); 
            $workerdateinit = $conn->quote($_POST['workerdateinit']); 
            $workerdateout= $conn->quote($_POST['workerdateout']); 

            $sqlWorker = "INSERT INTO worker (
                            workercode, workername1, workername2, workerlastname1, workerlastname2, 
                            workerhousbandname, workerbirthdate, workertypedoc, workerdoccity, workerdocnumber, 
                            workersecurenum, workercuanum, workercity, workeremail, workerphone1, workerphone2, workerimg, 
                            workerarea, workerrol, workersection, workeraddress, workernationality, workersex, workernit,
                            workercivilstatus, workerbanknum, workerdateinit, workerdateout
                          ) VALUES (
                            $workercode, $workername1, $workername2, $workerlastname1, $workerlastname2, 
                            $workerhousbandname, $workerbirthdate, $workertypedoc, $workerdoccity, $workerdocnumber, 
                            $workersecurenum, $workercuanum, $workercity, $workeremail, $workerphone1, $workerphone2, $img, 
                            $codearea, $codeoccupation, $codesection, $workeraddress, $workernationality, $workersex, $workernit, $workercivilstatust, $accountMain,
                            $workerdateinit, $workerdateout
                          )";

            if ($conn->exec($sqlWorker)) {
                $codeworker = $conn->lastInsertId();

                // Insertar en la tabla account
                $nameBanks = $_POST['nameBank'];
                $cuentaBanks = $_POST['cuentaBank'];

                foreach ($nameBanks as $index => $nameBank) {
                    $accountbank = $conn->quote($nameBank);
                    $accountnro = $conn->quote($cuentaBanks[$index]);

                    $sqlAccount = "INSERT INTO account (
                                    codeworker, accountbank, accountnro
                                  ) VALUES (
                                    $codeworker, $accountbank, $accountnro
                                  )";

                    if (!$conn->exec($sqlAccount)) {
                        throw new Exception("Error al insertar en la tabla account.");
                    }
                }

                // Insertar en la tabla family
                $familynames = $_POST['familyname'];
                $familylastnames = $_POST['familylastname'];
                $familysexes = $_POST['familysex'];
                $familyages = $_POST['familyage'];
                $familykins = $_POST['familykin'];

                foreach ($familynames as $index => $familyname) {
                    $familyname = $conn->quote($familyname);
                    $familylastname = $conn->quote($familylastnames[$index]);
                    $familysex = $conn->quote($familysexes[$index]);
                    $familyage = $conn->quote($familyages[$index]);
                    $familykin = $conn->quote($familykins[$index]);

                    $sqlFamily = "INSERT INTO family (
                                    codeworker, familyname, familylastname, familysex, familyage, familykin
                                  ) VALUES (
                                    $codeworker, $familyname, $familylastname, $familysex, $familyage, $familykin
                                  )";

                    if (!$conn->exec($sqlFamily)) {
                        throw new Exception("Error al insertar en la tabla family.");
                    }
                }

                // Insertar en la tabla turnw
                if (isset($_POST['codeturn']) && is_array($_POST['codeturn'])) {
                    foreach ($_POST['codeturn'] as $codeturn) {
                        $codeturn = $conn->quote($codeturn);
                        $turnwname = $conn->quote($_POST['turnwname']);
                        $turnwlastname = $conn->quote($_POST['turnwlastname']);

                        $sqlTurnw = "INSERT INTO turnw (
                                        codeworker, codeturn, turnwname, turnwlastname
                                      ) VALUES (
                                        $codeworker, $codeturn, $turnwname, $turnwlastname
                                      )";

                        if (!$conn->exec($sqlTurnw)) {
                            throw new Exception("Error al insertar en la tabla turnw para el turno $codeturn.");
                        }
                    }
                }
                
                
                
                
                
               
           
           // Insertamos los documentos
            $certificadosDir = '../../resource/certificados/';
            
            if (isset($_POST['grado-formacion']) && is_array($_POST['grado-formacion'])) {
                foreach ($_POST['grado-formacion'] as $index => $grado) {
                    $gradoFormacion = $conn->quote($grado);
                    $titulo = $conn->quote($_POST['titulo'][$index]);
                    $descripcionCurso = $conn->quote($_POST['descripcion-curso'][$index]);
                    $fechaCursada = $conn->quote($_POST['fecha-cursada'][$index]);
                    $urlCertificado = 'NULL';
                    
                    if (isset($_FILES['foto-certificado']['name'][$index])) {
                        $file = $_FILES['foto-certificado'];
                        // Agregar WebP y AVIF a las extensiones permitidas
                        $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'pdf', 'webp', 'avif'];
                        $maxFileSize = 30 * 1024 * 1024; // 30MB
                        
                        if ($file['error'][$index] === UPLOAD_ERR_OK) {
                            $fileSize = $file['size'][$index];
                            $extension = strtolower(pathinfo($file['name'][$index], PATHINFO_EXTENSION));
                            
                            if (in_array($extension, $extensionesPermitidas) && ($fileSize <= $maxFileSize)) {
                                // Generar nombre único
                                $nombreArchivo = uniqid('cert_', true) . '.' . $extension;
                                $rutaDestino = $certificadosDir . $nombreArchivo;
                                
                                // Mover el archivo subido
                                if (move_uploaded_file($file['tmp_name'][$index], $rutaDestino)) {
                                    $urlCertificado = $conn->quote('resource/certificados/' . $nombreArchivo);
                                } else {
                                    error_log("Error al mover el archivo subido: " . $file['name'][$index]);
                                    // Opcional: puedes agregar más detalles del error
                                    error_log("Error details: " . print_r(error_get_last(), true));
                                }
                            } else {
                                error_log("Archivo no permitido o muy grande: " . $file['name'][$index] . 
                                        " (Tipo: $extension, Tamaño: $fileSize bytes)");
                            }
                        } else {
                            error_log("Error en la subida del archivo: " . $file['name'][$index] . 
                                    " (Código error: " . $file['error'][$index] . ")");
                        }
                    }
                    
                    $sqlDocument = "INSERT INTO documentWorker 
                                  (codeWorker, gradoFormacion, titulo, urlCertificado, descripcionCurso, fechaCursada) 
                                  VALUES (
                                      $codeworker,
                                      $gradoFormacion,
                                      $titulo,
                                      $urlCertificado,
                                      $descripcionCurso,
                                      $fechaCursada
                                  )";
                    
                    if (!$conn->exec($sqlDocument)) {
                        throw new Exception("Error al insertar documento en la posición $index.");
                    }
                }
            }




                                
                
                
                
                
                
                

                $conn->commit();
                $_SESSION['message'] = 'Trabajador y datos relacionados agregados correctamente';
                $_SESSION['message_type'] = 'success';
            } else {
                $conn->rollBack();
                $_SESSION['message'] = 'Error al agregar el trabajador';
                $_SESSION['message_type'] = 'error';
            }
        } catch (Exception $e) {
            $conn->rollBack();
            $_SESSION['message'] = 'Error al agregar el trabajador: ' . $e->getMessage();
            $_SESSION['message_type'] = 'error';
        }
    } else {
        $_SESSION['message'] = 'Error al agregar el trabajador: ';
        $_SESSION['message_type'] = 'error';
    }
}

header("Location: ../../index.php?p=subviews/registrar");
exit;