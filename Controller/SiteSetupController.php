<?php
App::uses('Controller', 'Controller');
App::uses('File', 'Utility');
App::uses('Inflector', 'Utility');
App::uses('InstallManager', 'Install.Lib');


class SiteSetupController extends AppController {

    /**
     * Components
     *
     * @var array
     * @access public
     */
    public $components = array('Session');

    /**
     * Helpers
     *
     * @var array
     * @access public
     */
    public $layout = 'default';

    public $helpers = array(
        'Html' => array(
            'className' => 'Bs3Html'
        ),
        'Form' => array(
            'className' => 'PxForm'
            // 'className' => 'Bs3Form'
        ),
        'Session',
        'Paginator',
        'Number',
    );


    protected function _check() {
        $InstallManager = new InstallManager();
        // Si esta instalado no habra necesidad de checkear permisos
        if ($InstallManager->checkAppInstalled()) {
            $this->Session->setFlash('La Aplicación Ristorantino ya esta instalada.');
            return $this->redirect('/users/login');
        }
        // Si no esta instalado y no se puede escribir en las pcarpetas volvera al inicio
        if (!$InstallManager->checkAppInstalled()&&!$InstallManager->checkPerms())
        {

            return $this->redirect('/install');
        }

    }

    public function installsite()
    {
        $this->_check();
        $countries = array(
            'Europa'=>array(
                "AL"=>"Albania",
                "DE"=>"Alemania",
                "AD"=>"Andorra",
                "AM"=>"Armenia",
                "AT"=>"Austria",
                "AZ"=>"Azerbaiyán",
                "BE"=>"Bélgica",
                "BY"=>"Bielorrusia",
                "BA"=>"Bosnia y Herzegovina",
                "BG"=>"Bulgaria",
                "CY"=>"Chipre",
                "VA"=>"Ciudad del Vaticano (Santa Sede)",
                "HR"=>"Croacia",
                "DK"=>"Dinamarca",
                "SK"=>"Eslovaquia",
                "SI"=>"Eslovenia",
                "ES"=>"España",
                "EE"=>"Estonia",
                "FI"=>"Finlandia",
                "FR"=>"Francia",
                "GE"=>"Georgia",
                "GR"=>"Grecia",
                "HU"=>"Hungría",
                "IE"=>"Irlanda",
                "IS"=>"Islandia",
                "IT"=>"Italia",
                "XK"=>"Kosovo",
                "LV"=>"Letonia",
                "LI"=>"Liechtenstein",
                "LT"=>"Lituania",
                "LU"=>"Luxemburgo",
                "MK"=>"Macedonia, República de",
                "MT"=>"Malta",
                "MD"=>"Moldavia",
                "MC"=>"Mónaco",
                "ME"=>"Montenegro",
                "NO"=>"Noruega",
                "NL"=>"Países Bajos",
                "PL"=>"Polonia",
                "PT"=>"Portugal",
                "UK"=>"Reino Unido",
                "CZ"=>"República Checa",
                "RO"=>"Rumanía",
                "RU"=>"Rusia",
                "SM"=>"San Marino",
                "SE"=>"Suecia",
                "CH"=>"Suiza",
                "TR"=>"Turquía",
                "UA"=>"Ucrania",
                "YU"=>"Yugoslavia",
            ),

            "África"=>array(
                "AO"=>"Angola",
                "DZ"=>"Argelia",
                "BJ"=>"Benín",
                "BW"=>"Botswana",
                "BF"=>"Burkina Faso",
                "BI"=>"Burundi",
                "CM"=>"Camerún",
                "CV"=>"Cabo Verde",
                "TD"=>"Chad",
                "KM"=>"Comores",
                "CG"=>"Congo",
                "CD"=>"Congo, República Democrática del",
                "CI"=>"Costa de Marfil",
                "EG"=>"Egipto",
                "ER"=>"Eritrea",
                "ET"=>"Etiopía",
                "GA"=>"Gabón",
                "GM"=>"Gambia",
                "GH"=>"Ghana",
                "GN"=>"Guinea",
                "GW"=>"Guinea Bissau",
                "GQ"=>"Guinea Ecuatorial",
                "KE"=>"Kenia",
                "LS"=>"Lesoto",
                "LR"=>"Liberia",
                "LY"=>"Libia",
                "MG"=>"Madagascar",
                "MW"=>"Malawi",
                "ML"=>"Malí",
                "MA"=>"Marruecos",
                "MU"=>"Mauricio",
                "MR"=>"Mauritania",
                "MZ"=>"Mozambique",
                "NA"=>"Namibia",
                "NE"=>"Níger",
                "NG"=>"Nigeria",
                "CF"=>"República Centroafricana",
                "ZA"=>"República de Sudáfrica",
                "RW"=>"Ruanda",
                "EH"=>"Sahara Occidental",
                "ST"=>"Santo Tomé y Príncipe",
                "SN"=>"Senegal",
                "SC"=>"Seychelles",
                "SL"=>"Sierra Leona",
                "SO"=>"Somalia",
                "SD"=>"Sudán",
                "SS"=>"Sudán del Sur",
                "SZ"=>"Suazilandia",
                "TZ"=>"Tanzania",
                "TG"=>"Togo",
                "TN"=>"Túnez",
                "UG"=>"Uganda",
                "DJ"=>"Yibuti",
                "ZM"=>"Zambia",
                "ZW"=>"Zimbabue",
            ),

            "Oceanía"=>array(
                "AU"=>"Australia",
                "FM"=>"Micronesia, Estados Federados de",
                "FJ"=>"Fiji",
                "KI"=>"Kiribati",
                "MH"=>"Islas Marshall",
                "SB"=>"Islas Salomón",
                "NR"=>"Nauru",
                "NZ"=>"Nueva Zelanda",
                "PW"=>"Palaos",
                "PG"=>"Papúa Nueva Guinea",
                "WS"=>"Samoa",
                "TO"=>"Tonga",
                "TV"=>"Tuvalu",
                "VU"=>"Vanuatu",
            ),

            "Sudamérica"=>array(
                "AR"=>"Argentina",
                "BO"=>"Bolivia",
                "BR"=>"Brasil",
                "CL"=>"Chile",
                "CO"=>"Colombia",
                "EC"=>"Ecuador",
                "GY"=>"Guayana",
                "PY"=>"Paraguay",
                "PE"=>"Perú",
                "SR"=>"Surinam",
                "TT"=>"Trinidad y Tobago",
                "UY"=>"Uruguay",
                "VE"=>"Venezuela",
            ),

            "Norteamérica y Centroamérica"=>array(
                "AG"=>"Antigua y Barbuda",
                "BS"=>"Bahamas",
                "BB"=>"Barbados",
                "BZ"=>"Belice",
                "CA"=>"Canadá",
                "CR"=>"Costa Rica",
                "CU"=>"Cuba",
                "DM"=>"Dominica",
                "SV"=>"El Salvador",
                "US"=>"Estados Unidos",
                "GD"=>"Granada",
                "GT"=>"Guatemala",
                "HT"=>"Haití",
                "HN"=>"Honduras",
                "JM"=>"Jamaica",
                "MX"=>"México",
                "NI"=>"Nicaragua",
                "PA"=>"Panamá",
                "PR"=>"Puerto Rico",
                "DO"=>"República Dominicana",
                "KN"=>"San Cristóbal y Nieves",
                "VC"=>"San Vicente y Granadinas",
                "LC"=>"Santa Lucía",
            ),

            "Asia"=>array(
                "AF"=>"Afganistán",
                "SA"=>"Arabia Saudí",
                "BH"=>"Baréin",
                "BD"=>"Bangladesh",
                "MM"=>"Birmania",
                "BT"=>"Bután",
                "BN"=>"Brunéi",
                "KH"=>"Camboya",
                "CN"=>"China",
                "KP"=>"Corea, República Popular Democrática de",
                "KR"=>"Corea, República de",
                "AE"=>"Emiratos Árabes Unidos",
                "PH"=>"Filipinas",
                "IN"=>"India",
                "ID"=>"Indonesia",
                "IQ"=>"Iraq",
                "IR"=>"Irán",
                "IL"=>"Israel",
                "JP"=>"Japón",
                "JO"=>"Jordania",
                "KZ"=>"Kazajistán",
                "KG"=>"Kirguizistán",
                "KW"=>"Kuwait",
                "LA"=>"Laos",
                "LB"=>"Líbano",
                "MY"=>"Malasia",
                "MV"=>"Maldivas",
                "MN"=>"Mongolia",
                "NP"=>"Nepal",
                "OM"=>"Omán",
                "PK"=>"Paquistán",
                "QA"=>"Qatar",
                "SG"=>"Singapur",
                "SY"=>"Siria",
                "LK"=>"Sri Lanka",
                "TJ"=>"Tayikistán",
                "TH"=>"Tailandia",
                "TP"=>"Timor Oriental",
                "TM"=>"Turkmenistán",
                "UZ"=>"Uzbekistán",
                "VN"=>"Vietnam",
                "YE"=>"Yemen",
            ),
        );

        if(empty($this->request->data))
        {

        }

        if(!empty($this->request->data))
        {
            $Inf = new Inflector();
            $site_slug = $Inf->slug($this->request->data['Site']['alias'],"_");
            $mk_dir = $this->SiteSetup->createTenantsDir($site_slug);
            if($mk_dir)
            {
                $r = $this->SiteSetup->copySettingFile($site_slug,$this->request->data);
                if($r)
                {
                    // Dump del tenant
                    $dumptenant = $this->SiteSetup->createDumpTenantDB($site_slug,$this->request->data);


                    $this->loadModel("Install.Site");
                    $this->loadModel("Install.SitesUser");
                    $this->loadModel("Install.User");


                    $this->request->data['User']['rol_id'] = ADMIN_ROLE_ID;
                    $this->Site->create();
                    if($this->Site->save($this->request->data))
                    {
                        $site_id = $this->Site->id;
                    }
                    $this->User->create();
                    if($this->User->save($this->request->data))
                    {

                        $user_id = $this->User->id;
                        $this->request->data['SitesUser']['user_id'] = $user_id;
                        $this->request->data['SitesUser']['site_id'] = $site_id;
                        $this->SitesUser->create();
                        if($this->SitesUser->save($this->request->data))
                        {
                            $InstallManager = new InstallManager();
                            // Genera un Archivo de resumen
                            $resume_file = $this->SiteSetup->createResumeFile();
                            // Paso final, se copiaria el resumen para terminar con la instalacion
                            if($resume_file)
                            {
                                // Copia los Appcontroller y AppModel Para recurrir al Risto Plugin
                                return $this->Session->setFlash("Ristorantino se ha instalado con exito.", 'Risto.flash_success');

                            }
                            else
                            {
                                return $this->Session->setFlash("Ha ocurrido un error. Revise los permisos de escritura del Config.", 'Risto.flash_error');
                            }
                        }
                        else
                        {
                            return $this->Session->setFlash("Ha ocurrido un error. No se pudo crear el sitio.", 'Risto.flash_error');

                        }
                    }
                    else
                    {
                        return $this->Session->setFlash("No se pudo crear el user.", 'Risto.flash_error');
                    }

                }
                else
                {
                    return $this->Session->setFlash("No se pudo copiar los archivos, revise los permisos de /Tenants.", 'Risto.flash_error');
                }

            }
            else
            {
                return $this->Session->setFlash("Ha ocurrido un error; ".$mk_dir.".Revise los permisos del /Tenants y reintente, recuerde debe de tener permiso de acceso y escritura.", 'Risto.flash_error');

            }


        }
        $this->set(compact('countries'));
    }

public function getdbsource()
{
    $dumptenant = $this->SiteSetup->createDumpTenantDB("tenant2222",$this->request->data);

}

}