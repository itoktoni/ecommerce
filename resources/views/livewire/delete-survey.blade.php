<div>
    <button id="delete" onclick="confirm('Are you sure to delete data ?') || event.stopImmediatePropagation() || event.preventDefault();" wire:click="delete" value="{{ $id }}" class="btn btn-danger btn-block">Delete</button>
</div>