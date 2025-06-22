<div class="ms-1">
    <form method="GET" action="{{ $action }}" class="row mb-3" id="{{ $formId ?? 'filterForm' }}">
        <div class="row">
            {{-- @if ($showSpk) --}}
                <div class="col-md-3">
                    <label for="spk" class="form-label">SPK</label>
                    <input type="search" name="spk" id="spk" class="form-control"
                        placeholder="Masukkan nomor SPK" value="{{ request('spk') }}">
                </div>
            {{-- @endif --}}
            {{-- @if ($showInvoice)
                <div class="col-md-3">
                    <label for="invoice" class="form-label">Invoice</label>
                    <input type="search" name="invoice" id="invoice" class="form-control"
                        placeholder="Masukkan nomor invoice" value="{{ request('invoice') }}">
                </div>
            @endif --}}
            @if ($showPaymentMethod)
                <div class="col-md-2">
                    <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
                    <select name="status_pembayaran" id="status_pembayaran" class="form-select">
                        <option value=""
                            {{ request('status_pembayaran') === null || request('status_pembayaran') === '' ? 'selected' : '' }}>
                            Pilih Status</option>
                        <option value="0" {{ request('status_pembayaran') === '0' ? 'selected' : '' }}>Unpaid
                        </option>
                        <option value="1" {{ request('status_pembayaran') === '1' ? 'selected' : '' }}>Partial
                        </option>
                        <option value="2" {{ request('status_pembayaran') === '2' ? 'selected' : '' }}>Paid
                        </option>
                    </select>
                </div>
            @endif
            @if ($showStatusPemesanan)
                <div class="col-md-2">
                    <label for="status_pengerjaan" class="form-label">Status Pemesanan</label>
                    <select name="status_pengerjaan" id="status_pengerjaan" class="form-select">
                        <option value=""
                            {{ request('status_pengerjaan') === null || request('status_pengerjaan') === '' ? 'selected' : '' }}>
                            Pilih Status</option>
                        <option value="verif_pesanan"
                            {{ request('status_pengerjaan') === 'verif_pesanan' ? 'selected' : '' }}>Terverifikasi
                        </option>
                        <option value="belum_verif"
                            {{ request('status_pengerjaan') === 'belum_verif' ? 'selected' : '' }}>Belum Terverifikasi
                        </option>
                    </select>
                </div>
            @endif
            <div class="col-md-2">
                <label for="start_date" class="form-label">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" class="form-control"
                    value="{{ request('start_date') }}">
            </div>
            <div class="col-md-2">
                <label for="end_date" class="form-label">Tanggal Selesai</label>
                <input type="date" name="end_date" id="end_date" class="form-control"
                    value="{{ request('end_date') }}">
            </div>
            <div class="col-md-3 align-self-end">
                <button type="submit" class="btn btn-info btn-md"><i class="bi bi-funnel-fill me-1"></i>Filter</button>
                <a href="{{ $resetUrl }}" class="btn btn-secondary btn-md"><i class="bi bi-x-circle-fill me-1"></i>Reset</a>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('filterForm');

        form.addEventListener('submit', function(e) {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;

            if (startDate && endDate && startDate > endDate) {
                e.preventDefault();
                alert('Tanggal Mulai tidak boleh lebih besar dari Tanggal Selesai!');
            }
        });
    });
</script>
