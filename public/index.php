<?php

require __DIR__."/../vendor/autoload.php";

    $person = null;
    $radioPerson = $_POST['radioPerson'];

    function clientCode(Person $person)
    {
        return new $person;
    }

    if(isset($radioPerson)) {
        if($radioPerson == 'private') {
            $person = clientCode(new PrivatePerson());
        } elseif($radioPerson == 'legal') {
            $person = clientCode(new LegalPerson());
        }
    }




?>
<!DOCTYPE html>
<html lang="pt-br" style="height: 100%; ">
<head>
    <title>Abstract Factory</title>
    <meta charset="UTF-8">
    <script type="text/javascript" src="./bootstrap/js/bootstrap.js"></script>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.css">
</head>
<body style="background: linear-gradient(36deg, rgba(73,25,255,0.9) 0%, rgba(255,113,0,0.9) 100%); height: 100%">
<div class="container" style="height: 100%">
    <div class="row h-100" >
        <div class="col-8 offset-2" style="margin-top: auto; margin-bottom: auto;">
            <div class="card card-block">
                <div class="card-body">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <div class="row text-center">
                            <h2>Gerador de Pessoas</h2>
                        </div>
                        <br>
                        <div class="form-check" style="padding-left: 6vw; padding-right: 6vw; margin-bottom: 2vh">
                            <input class="form-check-input" type="radio" name="radioPerson" id="privatePerson" value="private" <?php echo (isset($radioPerson) && $radioPerson == 'private') ? 'checked' : '';?>>
                            <label class="form-check-label" for="privatePerson">
                                Pessoa física
                            </label>
                        </div>
                        <div class="form-check" style="padding-left: 6vw; padding-right: 6vw; margin-bottom: 2vh">
                            <input class="form-check-input" type="radio" name="radioPerson" id="legalPerson" value="legal" <?php echo (isset($radioPerson) && $radioPerson == 'legal') ? 'checked' : '';?>>
                            <label class="form-check-label" for="legalPerson">
                                Pessoa jurídica
                            </label>
                        </div>
                        <br>
                        <div class="form-group" style="padding-left: 3vw; padding-right: 3vw; margin-bottom: 2vh">
                            <label for="namePerson">Nome</label>
                            <input type="email" class="form-control" id="namePerson" placeholder="Nome" readonly="readonly" value="<?php echo empty($person) ? '' : $person->getName();?>">
                        </div>
                        <div class="form-group" style="padding-left: 3vw; padding-right: 3vw; margin-bottom: 2vh">
                            <label for="namePerson">Documento</label>
                            <input type="email" class="form-control" id="namePerson" placeholder="Documento" readonly="readonly" value="<?php echo empty($person) ? '' : $person->getDocument();?>">
                        </div>
                        <br>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-3">
                                <input type="submit" name="Simular" class="btn btn-outline-primary" value="Gerar" style="width: 100%">
                            </div>
                        </div>
                        <br>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

