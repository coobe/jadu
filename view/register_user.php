<script type="text/javascript" src="public/js/register.js"></script>

<div id="creation-message" class="message alert alert-success" style="display: none; top: 100px;">
    <p>User was successfully created</p>
</div>

<div id="register-user-dialog" class="hidden modal-dialog" title="Register a new User">
    <div id="register-error" class="row alert alert-danger error-message-small" style="display: none;">   
    </div>
   <form onsubmit="event.preventDefault();">
        <div class="row">
            <label class="col-xs-4 col-xs-offset-1 label label-default">Name</label>
            <input id="user-name" type="text" name="user-name" autocomplete="off" required />
        </div>
        <div class="row">
            <label class="col-xs-4 col-xs-offset-1 label label-default" >Password</label>
            <input id="register-password" type="password" name="register-password" autocomplete="off" required />
        </div>
       <div class="row">
            <label class="col-xs-4 col-xs-offset-1 label label-default">repeat Password</label>
            <input id="confirm-password" type="password" name="password-confirm" autocomplete="off" required />
        </div>
        <div class="row">
            <button id="modal-register-user" class="col-xs-4 col-xs-offset-1 btn btn-primary" name="register">Register</button>
        </div>
    </form>
</div>