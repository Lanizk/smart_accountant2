@extends('layouts.app')

@section('main')
<div class="row column_title mb-3">
  <div class="col-md-12 d-flex justify-content-between align-items-center">
    <h2>Cashbook</h2>
    <span class="badge bg-success fs-6 text-dark">
      Balance: KES {{ number_format($balance, 2) }}
    </span>
  </div>
</div>

<div class="row w-100">
  <div class="col-md-12">
    <div class="white_shd full margin_bottom_30">
      <div class="table-responsive-lg">
        <table class="table table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th>Date</th>
              <th>Description</th>
              <th>Payment Method</th>
              <th class="text-success">Cash Inflow (KES)</th>
              <th class="text-danger">Cash Outflow (KES)</th>
            </tr>
          </thead>
          <tbody>
            @php
              $totalInflow = 0;
              $totalOutflow = 0;
            @endphp

            @forelse($entries as $entry)
              <tr>
                <td>{{ \Carbon\Carbon::parse($entry->transaction_date)->format('d M Y') }}</td>
                <td>{{ $entry->description }}</td>
                <td>{{ $entry->payment_method }}</td>
                <td class="text-success fw-bold">
                  @if($entry->transaction_type === 'inflow')
                    {{ number_format($entry->amount, 2) }}
                    @php $totalInflow += $entry->amount; @endphp
                  @endif
                </td>
                <td class="text-danger fw-bold">
                  @if($entry->transaction_type === 'outflow')
                    {{ number_format($entry->amount, 2) }}
                    @php $totalOutflow += $entry->amount; @endphp
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center">No entries yet.</td>
              </tr>
            @endforelse
          </tbody>

          @if($entries->count() > 0)
          <tfoot class="table-light fw-bold">
            <tr>
              <td colspan="3" class="text-right">Totals:</td>
              <td class="text-success">{{ number_format($totalInflow, 2) }}</td>
              <td class="text-danger">{{ number_format($totalOutflow, 2) }}</td>
            </tr>
            <tr>
              <td colspan="3" class="text-right">Closing Balance:</td>
              <td colspan="2" class="text-dark">KES {{ number_format($totalInflow - $totalOutflow, 2) }}</td>
            </tr>
          </tfoot>
          @endif
        </table>
      </div>

      <div class="p-3">
        {{ $entries->links() }}
      </div>
    </div>
  </div>
</div>
@endsection

