<form action="{{ route($delete_url, $entityID) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this item?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
</form>