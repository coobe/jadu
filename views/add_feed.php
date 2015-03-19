<div id="add-feed-dialog" class="modal-dialog" title="Add a new Feed">
   <form onsubmit="event.preventDefault();">
        <div class="row">
            <label class="col-md-2 label label-default" for="feed-name">Name</label>
            <input id="feed-name" type="text" name="feed-name" required />
        </div>
        <div class="row">
            <label class="col-md-2 label label-default"  for="feed-url">Url</label>
            <input id="feed-url" type="text" name="feed-url" required />
        </div>
        <div class="row">
            <button id="modal-add-feed" class="col-md-2 col-md-offset-3 btn btn-primary" name="add">Add</button>
            <button id="modal-add-feed-cancel" class="col-md-2 col-md-offset-2  btn btn-danger" name="cancel">Cancel</button>
        </div>
    </form>
</div>