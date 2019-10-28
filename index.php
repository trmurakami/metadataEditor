<?php 

/* Load libraries for PHP composer */ 
require (__DIR__.'/../vendor/autoload.php'); 

/* Exibir erros */
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

if ($_REQUEST["crossrefDoi"]) {
    $clientCrossref = new RenanBr\CrossRefClient();
    $clientCrossref->setUserAgent('GroovyBib/1.1 (http://tecbib.com/metadataEditor/; mailto:trmurakami@gmail.com)');
    $exists = $clientCrossref->exists('works/'.$_REQUEST["crossrefDoi"].'');
    if ($exists == true) {
        $work = $clientCrossref->request('works/'.$_REQUEST["crossrefDoi"].'');
        print("<pre>".print_r($work, true)."</pre>");
    }
}


?>


<br/><br/><br/><br/><br/>

<?php print_r($_REQUEST); ?>

<!doctype html>
<html lang="pt_BR">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- dependencies (jquery, handlebars and bootstrap) -->
        <script type="text/javascript" src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.5/handlebars.min.js"></script>
        <link type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet"/>
        <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        
        <!-- alpaca -->
        <link type="text/css" href="//cdn.jsdelivr.net/npm/alpaca@1.5.27/dist/alpaca/bootstrap/alpaca.min.css" rel="stylesheet"/>
        <script type="text/javascript" src="//cdn.jsdelivr.net/npm/alpaca@1.5.27/dist/alpaca/bootstrap/alpaca.min.js"></script>

        <title>Editor de registros</title>
    </head>
    <body>
        <div class="container">
            <h1>Editor</h1>

            <div id="form"></div>
            <script type="text/javascript">
                $("#form").alpaca({
                    "data":{
                        "name": "Título",
                        "subtitle": "Subtítulo"
                    },
                    "options":{
                        "form": {
                            "attributes": {
                                "action": "http://localhost/metadataEditor/index.php",
                                "method": "post"
                            },
                            "buttons": {
                                "submit": {},
                                "validate": {
                                    "title": "Validate and view JSON!",
                                    "click": function() {
                                        this.refreshValidationState(true);
                                        if (this.isValid(true)) {
                                            var value = this.getValue();
                                            alert(JSON.stringify(value, null, "  "));
                                        }
                                    }
                                },                                
                                "reset": {}
                            }
                        },
                        "fields": {
                            "helper": "",
                            "name": {
                                "size": 1000
                            }
                        }                       
                    },
                    "schema": {
                        "title": "Dados da obra",
                        "type": "object",
                        "properties": {
                            "name": {
                                "type": "string",
                                "title": "Título",
                                "required": true
                            },
                            "subtitle": {
                                "type": "string",
                                "title": "Subtítulo",
                                "required": false
                            },
                            "author": {
                                "title": "Autores",
                                "type": "array",
                                "items": {
                                    "title": "Autor",
                                    "type": "object",
                                    "properties":{
                                        "personName":{
                                            "type": "string",
                                            "title": "Nome do autor",
                                        },
                                        "organizationName":{
                                            "type": "string",
                                            "title": "Instituição",
                                        }
                                    }
  
                                }                                 
                            }
                        }
                    },
                    "view": {
                        "locale": "pt_BR"
                    }
                });

            </script>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    </body>
</html>