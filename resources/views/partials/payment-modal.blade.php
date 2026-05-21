{{-- Payment Modal untuk Kas Kelas --}}
<div id="kas-payment-modal" class="fixed inset-0 z-50 items-center justify-center p-4" style="display:none;">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closePaymentModal()"></div>
    <div class="relative bg-white dark:bg-slate-800 rounded-2xl shadow-2xl w-full max-w-sm p-6 z-10">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-base font-semibold text-slate-800 dark:text-slate-100">Bayar Kas Kelas</h2>
            <button onclick="closePaymentModal()" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-400 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="mb-4">
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-2 font-medium">Pilih nominal</p>
            <div class="grid grid-cols-3 gap-2">
                @foreach([5000,10000,20000,25000,50000,100000] as $nominal)
                <button type="button" onclick="setNominal({{ $nominal }})"
                        class="nominal-btn py-2 text-sm font-medium rounded-lg border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors"
                        data-val="{{ $nominal }}">
                    Rp {{ number_format($nominal,0,',','.') }}
                </button>
                @endforeach
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1.5">Atau masukkan nominal lain</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400">Rp</span>
                <input type="number" id="kas-amount" min="1000" step="1000" placeholder="0"
                       class="w-full border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 rounded-lg pl-9 pr-3 py-2.5 text-sm text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
            </div>
        </div>

        <div class="mb-5">
            <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1.5">Catatan (opsional)</label>
            <input type="text" id="kas-note" placeholder="Kas bulan April..." maxlength="100"
                   class="w-full border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 rounded-lg px-3 py-2.5 text-sm text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
        </div>

        <button type="button" onclick="processPayment()"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl text-sm font-semibold transition-colors">
            Lanjutkan Pembayaran
        </button>
        <p class="text-center text-[10px] text-slate-400 mt-3">Pembayaran aman melalui Midtrans</p>
    </div>
</div>

@if(config('services.midtrans.is_production'))
<script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
@else
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
@endif

<script>
function openPaymentModal() {
    document.getElementById('kas-payment-modal').style.display = 'flex';
}
function closePaymentModal() {
    document.getElementById('kas-payment-modal').style.display = 'none';
}
function setNominal(val) {
    document.getElementById('kas-amount').value = val;
    document.querySelectorAll('.nominal-btn').forEach(b => {
        const isSelected = parseInt(b.dataset.val, 10) === val;
        b.classList.toggle('bg-blue-600', isSelected);
        b.classList.toggle('text-white', isSelected);
        b.classList.toggle('border-blue-600', isSelected);
    });
}
async function processPayment() {
    const amount = parseInt(document.getElementById('kas-amount').value, 10);
    const note = document.getElementById('kas-note').value;
    if (!amount || amount < 1000) {
        alert('Masukkan nominal minimal Rp 1.000');
        return;
    }

    try {
        const res = await fetch('{{ route('payment.create') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ amount, note })
        });
        const data = await res.json();
        if (!res.ok || data.error) {
            throw new Error(data.error || 'Terjadi kesalahan pembayaran.');
        }

        closePaymentModal();
        window.snap.pay(data.snap_token, {
            onSuccess: function(result) {
                alert('Pembayaran berhasil! Order ID: ' + result.order_id);
                location.reload();
            },
            onPending: function(result) {
                alert('Menunggu pembayaran. Order ID: ' + result.order_id);
            },
            onError: function(result) {
                alert('Pembayaran gagal. Silakan coba lagi.');
                openPaymentModal();
            },
            onClose: function() {
                openPaymentModal();
            }
        });
    } catch (err) {
        alert('Error: ' + err.message);
    }
}
</script>
