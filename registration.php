<?php
include "./header.php";

?>
<div class="container">

    <form class="well form-horizontal" action=" " method="post" id="contact_form">
        <fieldset>

            <legend>
                <center>
                    <h2><b>Registreerimise vorm</b></h2>
                </center><hr>
            </legend><br>

            <div class="form-group">
                <label class="col-md-4 control-label">Eesnimi</label>
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <i class="material-icons">account_box</i>
                        <input name="first_name" placeholder="First Name" class="form-control" type="text">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Perenimi</label>
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <i class="material-icons">account_box</i>
                        <input name="last_name" placeholder="Last Name" class="form-control" type="text">
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-4 control-label">E-Mail</label>
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <i class="material-icons">contact_mail</i>
                        <input name="email" placeholder="E-Mail Address" class="form-control" type="text">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Telefon</label>
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <i class="material-icons">phone</i>
                        <input name="phone" placeholder="+372" class="form-control" type="phone">
                    </div>
                </div>
            </div>
            
            <div class="form-group">
            <i class="material-icons">payment</i>
                <div class="col-md-4 inputGroupContainer">
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" id="seb-radio" value="SEB" checked>
                    <label class="form-check-label" for="seb-radio">Seb pank </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label"></label>
                <div class="col-md-4"><br>
                    <button type="submit" class="btn btn-warning">Vormista tellimus<span class="glyphicon glyphicon-send"></span></button>
                </div>
            </div>

        </fieldset>
    </form>
</div>
</div>