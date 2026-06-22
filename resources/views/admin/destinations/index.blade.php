<x-app-layout>
    <x-slot name="header">
        Manage Destinations
    </x-slot>

    @if(session('success'))
        <div class="alert-box alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="admin-actions">
        <a href="{{ route('admin.destinations.create') }}" class="btn-gold">
            <i class="fas fa-plus-circle"></i> Create New Destination
        </a>
    </div>

    @if($destinations->count())
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($destinations as $dest)
                        <tr>
                            <td>
                                <div class="table-title-cell">
                                    <div class="table-title">{{ $dest->name }}</div>
                                    <div class="table-excerpt">{{ Str::limit($dest->overview ?? '', 60) }}</div>
                                </div>
                            </td>
                            <td class="type-cell">{{ ucfirst(str_replace('_', ' ', $dest->type)) }}</td>
                            <td>
                                @if($dest->is_published)
                                    <span class="status-badge status-published">Published</span>
                                @else
                                    <span class="status-badge status-draft">Draft</span>
                                @endif
                            </td>
                            <td>{{ $dest->creator?->name ?? 'Unknown' }}</td>
                            <td class="actions-cell">
                                <a href="{{ route('destinations.show', $dest->slug) }}" target="_blank" class="action-btn view"
                                    title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.destinations.edit', $dest) }}" class="action-btn edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.destinations.destroy', $dest) }}" method="POST"
                                    style="display:inline;"
                                    onsubmit="return confirm('Are you sure? This will delete all images too.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $destinations->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-map-marked-alt"></i>
            <h3>No destinations yet</h3>
            <p>Click "Create New Destination" to add your first destination.</p>
        </div>
    @endif
</x-app-layout>

<style>
    .admin-actions {
        margin-bottom: 2rem;
    }

    .table-wrapper {
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-lighter);
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        text-align: left;
        padding: 1rem 1.5rem;
        background: var(--sand-light);
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--text-muted);
        border-bottom: 1px solid var(--border-light);
    }

    td {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border-lighter);
        font-size: 0.9rem;
        color: var(--text-primary);
        vertical-align: middle;
    }

    tr:last-child td {
        border-bottom: none;
    }

    tr:hover td {
        background: rgba(244, 234, 219, 0.3);
    }

    .text-right {
        text-align: right;
    }

    .table-title {
        font-weight: 700;
        color: var(--med-blue);
        margin-bottom: 0.2rem;
    }

    .table-excerpt {
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    .type-cell {
        text-transform: capitalize;
    }

    .status-badge {
        display: inline-block;
        padding: 0.2rem 0.8rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .status-published {
        background: #E8F5E9;
        color: #2E7D32;
    }

    .status-draft {
        background: #FFF3E0;
        color: #E65100;
    }

    .actions-cell {
        display: flex;
        gap: 0.5rem;
        justify-content: flex-end;
    }

    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: 0.85rem;
        transition: all var(--transition);
    }

    .action-btn.view {
        background: #E3F2FD;
        color: #1565C0;
    }

    .action-btn.view:hover {
        background: #1565C0;
        color: white;
    }

    .action-btn.edit {
        background: var(--sand-light);
        color: var(--tunisia-gold);
    }

    .action-btn.edit:hover {
        background: var(--tunisia-gold);
        color: white;
    }

    .action-btn.delete {
        background: #FFEAEA;
        color: var(--tunisia-red);
    }

    .action-btn.delete:hover {
        background: var(--tunisia-red);
        color: white;
    }

    .pagination-wrapper {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-lighter);
    }

    .empty-state i {
        font-size: 3rem;
        color: var(--tunisia-gold);
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        color: var(--med-blue);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: var(--text-muted);
    }

    @media (max-width: 768px) {

        th,
        td {
            padding: 0.8rem;
        }

        .actions-cell {
            flex-wrap: wrap;
        }
    }
</style>