<x-app-layout>
    <x-slot name="header">
        My Trips
    </x-slot>

    <div class="dashboard-container">
        <!-- Welcome message -->
        <div class="welcome-card">
            <div class="welcome-avatar">
                <i class="fas fa-user-circle"></i>
            </div>
            <div class="welcome-text">
                <h2>Welcome back, {{ Auth::user()->name }}!</h2>
                <p>Manage your trips, track bookings, and share your Tunisian adventures.</p>
            </div>
            <a href="{{ route('trips.create') }}" class="btn-gold">
                <i class="fas fa-plus"></i> Create New Trip
            </a>
        </div>

        @if(session('success'))
            <div class="alert-box alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($trips->count())
            <div class="trips-table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Destination</th>
                            <th>Date</th>
                            <th>Price</th>
                            <th>Seats</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trips as $trip)
                            <tr>
                                <td>
                                    <div class="trip-title-cell">
                                        @if($trip->image)
                                            <img src="{{ asset('storage/' . $trip->image) }}" alt="{{ $trip->title }}"
                                                class="trip-thumb">
                                        @endif
                                        <span>{{ $trip->title }}</span>
                                    </div>
                                </td>
                                <td>{{ $trip->destination }}</td>
                                <td>{{ $trip->date->format('M d, Y') }}</td>
                                <td>{{ number_format($trip->price, 2) }} TND</td>
                                <td>{{ $trip->available_seats }}</td>
                                <td class="text-right">
                                    <div class="action-buttons">
                                        <a href="{{ route('trips.show', $trip) }}" class="action-btn view" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('trips.edit', $trip) }}" class="action-btn edit" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('trips.destroy', $trip) }}" method="POST"
                                            onsubmit="return confirm('Delete this trip?');" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrapper">
                {{ $trips->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-map-marked-alt"></i>
                <h3>No trips yet</h3>
                <p>You haven’t created any trips. Start sharing your Tunisian journeys!</p>
                <a href="{{ route('trips.create') }}" class="btn-gold">Create Your First Trip</a>
            </div>
        @endif
    </div>
</x-app-layout>

<style>
    .dashboard-container {
        max-width: 1100px;
        margin: 0 auto;
    }

    /* Welcome card */
    .welcome-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 2rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-lighter);
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap;
        margin-bottom: 2rem;
    }

    .welcome-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: var(--sand-light);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: var(--tunisia-gold);
    }

    .welcome-text {
        flex: 1;
    }

    .welcome-text h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--med-blue);
        margin-bottom: 0.3rem;
    }

    .welcome-text p {
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    /* Table */
    .trips-table-wrapper {
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-lighter);
        overflow: hidden;
        margin-bottom: 2rem;
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

    .trip-title-cell {
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .trip-thumb {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: var(--radius-sm);
    }

    .action-buttons {
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
        margin-bottom: 1.5rem;
    }

    @media (max-width: 768px) {
        .welcome-card {
            flex-direction: column;
            text-align: center;
        }

        .trips-table-wrapper {
            overflow-x: auto;
        }
    }
</style>