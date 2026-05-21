@extends('layouts.app')

@section('title', 'Kas Online')
@section('content')

<div class="space-y-6">
    <div class="grid gap-4 xl:grid-cols-[1.4fr_0.9fr]">
        <div class="rounded-3xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Total Kas Terkumpul</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-900 dark:text-white">{{ 'Rp ' . number_format($totalCollected, 0, ',', '.') }}</p>
                </div>
                <div class="rounded-3xl bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 dark:bg-blue-900/20 dark:text-blue-200">{{ $unpaidCount }} Belum bayar</div>
            </div>

            <div class="mt-8 grid gap-4 sm:grid-cols-2">
                <div class="rounded-3xl bg-slate-50 dark:bg-slate-900/50 p-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Jumlah Transaksi</p>
                    <p class="mt-3 text-2xl font-semibold text-slate-900 dark:text-white">{{ $transactions->total() }}</p>
                </div>
                <div class="rounded-3xl bg-slate-50 dark:bg-slate-900/50 p-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Transaksi Sukses</p>
                    <p class="mt-3 text-2xl font-semibold text-slate-900 dark:text-white">{{ $successfulCount ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm p-6">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Bayar Kas</h2>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Pilih metode pembayaran untuk membayar kas online.</p>

            @if(auth()->user()->student)
            <div x-data="{ method: '', showForm: false, amount: 50000, week: '' }" class="mt-6">
                {{-- Payment Method Selection --}}
                <div>
                    <p class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-3">Pilih Metode Pembayaran</p>
                    <div class="grid gap-3 sm:grid-cols-3">
                        <button type="button" @click="method = 'qris'" :class="method === 'qris' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-slate-200 dark:border-slate-700'" class="rounded-2xl border-2 p-3 text-center transition hover:border-blue-400">
                            <div class="text-sm font-semibold text-slate-900 dark:text-white">QRIS</div>
                        </button>
                        <button type="button" @click="method = 'gopay'" :class="method === 'gopay' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-slate-200 dark:border-slate-700'" class="rounded-2xl border-2 p-3 text-center transition hover:border-blue-400">
                            <div class="text-sm font-semibold text-slate-900 dark:text-white">GoPay</div>
                        </button>
                        <button type="button" @click="method = 'ovo'" :class="method === 'ovo' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-slate-200 dark:border-slate-700'" class="rounded-2xl border-2 p-3 text-center transition hover:border-blue-400">
                            <div class="text-sm font-semibold text-slate-900 dark:text-white">OVO</div>
                        </button>
                        <button type="button" @click="method = 'dana'" :class="method === 'dana' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-slate-200 dark:border-slate-700'" class="rounded-2xl border-2 p-3 text-center transition hover:border-blue-400">
                            <div class="text-sm font-semibold text-slate-900 dark:text-white">DANA</div>
                        </button>
                        <button type="button" @click="method = 'shopeepay'" :class="method === 'shopeepay' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-slate-200 dark:border-slate-700'" class="rounded-2xl border-2 p-3 text-center transition hover:border-blue-400">
                            <div class="text-sm font-semibold text-slate-900 dark:text-white">ShopeePay</div>
                        </button>
                        <button type="button" @click="method = 'transfer'" :class="method === 'transfer' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-slate-200 dark:border-slate-700'" class="rounded-2xl border-2 p-3 text-center transition hover:border-blue-400">
                            <div class="text-sm font-semibold text-slate-900 dark:text-white">Transfer Bank</div>
                        </button>
                        <button type="button" @click="method = 'bca'" :class="method === 'bca' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-slate-200 dark:border-slate-700'" class="rounded-2xl border-2 p-3 text-center transition hover:border-blue-400">
                            <div class="text-sm font-semibold text-slate-900 dark:text-white">BCA</div>
                        </button>
                        <button type="button" @click="method = 'mandiri'" :class="method === 'mandiri' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-slate-200 dark:border-slate-700'" class="rounded-2xl border-2 p-3 text-center transition hover:border-blue-400">
                            <div class="text-sm font-semibold text-slate-900 dark:text-white">Mandiri</div>
                        </button>
                        <button type="button" @click="method = 'bni'" :class="method === 'bni' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-slate-200 dark:border-slate-700'" class="rounded-2xl border-2 p-3 text-center transition hover:border-blue-400">
                            <div class="text-sm font-semibold text-slate-900 dark:text-white">BNI</div>
                        </button>
                        <button type="button" @click="method = 'cash'" :class="method === 'cash' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-slate-200 dark:border-slate-700'" class="rounded-2xl border-2 p-3 text-center transition hover:border-blue-400">
                            <div class="text-sm font-semibold text-slate-900 dark:text-white">Cash</div>
                        </button>
                    </div>
                </div>

                {{-- Bank Transfer Info --}}
                <template x-if="['bca','mandiri','bni','transfer'].includes(method)">
                    <div class="mt-6 p-4 rounded-2xl bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800">
                        <p class="text-sm font-semibold text-blue-900 dark:text-blue-200 mb-2">Informasi Transfer Bank</p>
                        <div class="space-y-2 text-sm text-blue-800 dark:text-blue-300">
                            <p><span class="font-medium">Nama Penerima:</span> SMK AR-RAHMAT</p>
                            <p><span class="font-medium">Nomor Rekening:</span> <span x-text="method === 'bca' ? '1234567890' : method === 'mandiri' ? '9876543210' : method === 'bni' ? '1111222233' : '—'"></span></p>
                            <p><span class="font-medium">Bank:</span> <span x-text="method === 'bca' ? 'BCA' : method === 'mandiri' ? 'Mandiri' : method === 'bni' ? 'BNI' : 'Sesuai pilihan Anda'"></span></p>
                        </div>
                    </div>
                </template>

                {{-- Payment Form --}}
                <div x-show="method" x-transition class="mt-6 space-y-4">
                    <form action="{{ route('kas.pay') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="student_id" value="{{ auth()->user()->student->id }}">
                        <input type="hidden" name="method" :value="method">
                        
                        <div>
                            <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Nominal</label>
                            <input type="number" name="amount" x-model="amount" min="5000" value="50000" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Minggu (Opsional)</label>
                            <select name="week" x-model="week" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100">
                                <option value="">— Pilih minggu —</option>
                                <option value="1">Minggu 1</option>
                                <option value="2">Minggu 2</option>
                                <option value="3">Minggu 3</option>
                                <option value="4">Minggu 4</option>
                            </select>
                        </div>

                        <div class="rounded-2xl bg-slate-50 dark:bg-slate-900/50 p-4">
                            <p class="text-xs uppercase tracking-widest text-slate-500 dark:text-slate-400">Total Pembayaran</p>
                            <p class="mt-2 text-2xl font-semibold text-slate-900 dark:text-white">
                                Rp <span x-text="new Intl.NumberFormat('id-ID').format(amount)"></span>
                            </p>
                        </div>

                        <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition">
                            Lanjutkan Pembayaran
                        </button>
                    </form>
                </div>

                <div x-show="!method" x-transition class="mt-6 rounded-3xl bg-amber-50 p-4 text-sm text-amber-700 dark:bg-amber-900/20 dark:text-amber-200">
                    Pilih metode pembayaran untuk melanjutkan.
                </div>
            </div>
            @else
            <div class="mt-6 rounded-3xl bg-amber-50 p-4 text-sm text-amber-700 dark:bg-amber-900/20 dark:text-amber-200">
                Anda tidak memiliki profil siswa aktif untuk melakukan pembayaran kas.
            </div>
            @endif
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm p-6">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Riwayat Transaksi</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Transaksi kas terbaru siswa dan status.</p>
            </div>
            <span class="text-sm text-slate-400">Total {{ $transactions->total() }}</span>
        </div>

        <div class="mt-6 space-y-3">
            @foreach($transactions as $transaction)
            <div class="rounded-3xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50 p-4 flex items-center justify-between gap-4">
                <div>
                    <p class="font-semibold text-slate-900 dark:text-white">{{ $transaction->student->user->name }}</p>
                    <p class="text-sm text-slate-500 dark:text-slate-400">{{ ucfirst($transaction->status) }} — {{ $transaction->description ?? 'Kas bulanan' }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ 'Rp ' . number_format($transaction->amount, 0, ',', '.') }}</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ $transaction->created_at->format('d M Y') }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6">{{ $transactions->links() }}</div>
    </div>
</div>

@endsection