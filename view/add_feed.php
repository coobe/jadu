<div id="add-feed-dialog" class="hidden modal-dialog" title="Add a new Feed" style="text-align: center;">
   <form onsubmit="event.preventDefault();" style="margin: auto;">
        <div class="row">
            <label class="col-xs-4 col-xs-offset-1 label label-default">Name</label>
            <input id="feed-name" type="text" name="feed-name" required />
        </div>
        <div class="row">
            <label class="col-xs-4 col-xs-offset-1 label label-default">Url</label>
            <input id="feed-url" type="text" name="feed-url" required  />
        </div>
        <div class="row">
            <button id="modal-add-feed" class="col-xs-4 col-xs-offset-1 btn btn-primary" name="add">Save</button>
        </div>
    </form>
</div>
