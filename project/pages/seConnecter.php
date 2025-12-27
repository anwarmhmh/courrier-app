<?php
    session_start();
    require_once('connexiondb.php');
    
    $CIN=isset($_POST['CIN'])?$_POST['CIN']:"";
    
    $modepass=isset($_POST['modepass'])?$_POST['modepass']:"";

    $requete="select * 
                from utilisateur where CIN='$CIN'";
    
    $requete1="select * 
                from client where identifiant='$CIN'";
                
                $result = mysqli_query($conn, $requete);

                $result1 = mysqli_query($conn, $requete1);
            

               
                    if($result && mysqli_num_rows($result) > 0)
                    {
    
                        $user_data = mysqli_fetch_assoc($result);
                        
                        if( $user_data['modepass'] ===$modepass && $user_data['role'] ==="admin")
                        {
                            $_SESSION['user'] = $user_data;
                            header("Location: Client.php");
                            die;
                        }
                        elseif ($user_data['modepass'] ===$modepass && $user_data['role'] ==="collecteur") {
                            $_SESSION['user'] = $user_data;
                            header("Location: Client.php");
                            die;
                        }
                        else{
                            $_SESSION['erreurLogin']="<strong>Erreur!! :</strong>Votre mot de passe incorrecte !!!";        
                            header('location:login.php');
                        }
                        
                        
                    }
                    elseif($result1 && mysqli_num_rows($result1) > 0)
                    {
                        $user_data = mysqli_fetch_assoc($result1);

                            if( $user_data['modepass'] === $modepass && $user_data['statu']=='active') 
                            {
                                $_SESSION['user'] = $user_data;
                                header("Location: envoi.php");
                            die;
                            }
                            elseif($user_data['modepass'] === $modepass && $user_data['statu']=='desactive'){
                                $_SESSION['erreurLogin']="<strong>Erreur!! :</strong> Votre Compte et desactiver !!!";        
                                header('location:login.php');
                            }
                            else {
                                $_SESSION['erreurLogin']="<strong>Erreur!! :</strong> Votre mot de passe incorrecte !!!";        
                            header('location:login.php');
                            }
                        }
                    else
                    {
                            $_SESSION['erreurLogin']="<strong>Erreur!! :</strong>Votre intitulé Client inccorect !!!";        
                            header('location:login.php');
                    }
                    
                
                
            ?>   



