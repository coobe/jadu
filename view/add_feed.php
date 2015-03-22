<div id="add-feed-dialog" class="col-md-6 col-md-offset-4 modal-dialog" title="Add a new Feed" style="text-align: center;">
   <form onsubmit="event.preventDefault();" style="margin: auto;">
        <div class="row">
            <label class="col-xs-3 col-xs-offset-2 label label-default">Name</label>
            <input id="feed-name" type="text" name="feed-name" class="col-md-6 col-md-offset-4" required />
        </div>
        <div class="row">
            <label class="col-xs-3 col-xs-offset-2 label label-default">Url</label>
            <input id="feed-url" type="text" name="feed-url" required class="col-md-6 col-md-offset-4" />
        </div>
        <div class="row">
            <button id="modal-add-feed" class="col-xs-3 col-xs-offset-2 btn btn-primary" name="add">Save</button>
        </div>
    </form>
</div>
