@extends('super_admin.layouts.master')
@section('title', 'Invoice')
@section('page-title', 'Invoice')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card overflow-hidden">
            <div class="card-status bg-primary"></div>
            <div class="card-body">
                <h2 class="text-muted font-weight-bold">INVOICE</h2>
                @include('includes.messages')

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fe fe-check-circle"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
                @endif
                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fe fe-alert-triangle"></i> {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
                @endif

                <div class="d-flex mb-3 flex-wrap">
                    @if($invoice->status === 'unpaid' || $invoice->status === 'partial')
                    <button type="button" class="btn btn-success mr-2 mb-2"
                        data-toggle="modal" data-target="#stkPushModal">
                        <i class="fe fe-smartphone mr-1"></i> Initiate M-Pesa STK Push
                    </button>
                    @endif
                    <form method="POST" action="{{ route('super.invoices.message', $invoice->id) }}" class="mr-2 mb-2">
                        @csrf
                        <button type="submit" class="btn btn-secondary">
                            <i class="fe fe-message-circle mr-1"></i> Send Message
                        </button>
                    </form>
                    <a href="{{ route('super.invoices.pdf', $invoice->id) }}" target="_blank"
                        class="btn btn-info mr-2 mb-2">
                        <i class="fe fe-download mr-1"></i> Download PDF
                    </a>
                    <a href="{{ route('super.invoices.print', $invoice->id) }}" target="_blank"
                        class="btn btn-dark mb-2">
                        <i class="fe fe-printer mr-1"></i> Print Invoice
                    </a>
                </div>

                <div class="card-body pl-0 pr-0">
                    <div class="row">
                        <div class="col-sm-6">
                            <span>Invoice No.</span><br>
                            <strong>{{ $invoice->invoice_number }}</strong>
                        </div>
                        <div class="col-sm-6 text-right">
                            <span>Generated Date</span><br>
                            <strong>{{ \Carbon\Carbon::parse($invoice->created_at)->format('d M Y, H:i') }}</strong>
                        </div>
                    </div>
                </div>

                <div class="dropdown-divider"></div>

                <div class="row pt-4">
                    <div class="col-lg-6">
                        <p class="h5 font-weight-bold">Billing Details</p>
                        <address>
                            <li>Organization: <span class="text-success">{{ $invoice->org_name }}</span></li>
                            <li>Subdomain: <span class="text-success">{{ $invoice->org_slug }}.lipakodi.co.ke</span></li>
                            <li>Type:
                                @if($invoice->type === 'sms_credits')
                                    <span class="text-info font-weight-bold">SMS Credits</span>
                                @else
                                    <span class="text-primary font-weight-bold">Subscription</span>
                                @endif
                            </li>
                            <li>Status:
                                @if($invoice->status === 'paid')
                                    <span class="text-success font-weight-bold">PAID</span>
                                @elseif($invoice->status === 'partial')
                                    <span class="text-warning font-weight-bold">PARTIAL PAYMENT</span>
                                @elseif($invoice->status === 'overpayment')
                                    <span style="color:#6f42c1;" class="font-weight-bold">OVERPAYMENT</span>
                                @else
                                    <span class="text-danger font-weight-bold">UNPAID</span>
                                @endif
                            </li>
                        </address>
                    </div>
                    <div class="col-lg-6 text-right">
                        <p class="h5 font-weight-bold">Bill To</p>
                        <address>
                            Organization: <strong>{{ $invoice->org_name }}</strong><br>
                            Phone: {{ $invoice->org_phone ?? 'N/A' }}<br>
                            Email: {{ $invoice->org_email ?? 'N/A' }}<br>
                            Due Date: <strong>{{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}</strong>
                        </address>
                    </div>
                </div>

                <div class="table-responsive push">
                    <table class="table table-bordered table-hover text-nowrap">
                        <tr>
                            <th class="d-none d-sm-table-cell">DESCRIPTION</th>
                            <th class="text-right">TOTAL</th>
                        </tr>
                        <tr>
                            <td class="d-none d-sm-table-cell">
                                {{ $invoice->description ?? ($invoice->type === 'sms_credits' ? 'SMS Credits Purchase' : 'Subscription Fee') }}
                            </td>
                            <td class="text-right">KES {{ number_format($invoice->amount) }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-uppercase text-right h5 mb-0">Sub Total</td>
                            <td class="text-right">KES {{ number_format($invoice->amount) }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-uppercase text-right h5 mb-0">Total Paid</td>
                            <td class="text-right text-success text-bold">
                                KES {{ $invoice->status === 'paid' ? number_format($invoice->amount) : '0' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-uppercase text-right h5 mb-0">Total Due</td>
                            <td class="text-right text-danger text-bold">
                                KES {{ $invoice->status === 'paid' ? '0' : number_format($invoice->amount) }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-right">
                                <a href="{{ route('super.invoices.edit', $invoice->id) }}" class="btn btn-success">
                                    <i class="fe fe-edit"></i> Edit Invoice
                                </a>
                                <a href="{{ route('super.invoices.list') }}" class="btn btn-secondary ml-2">
                                    <i class="fe fe-arrow-left"></i> Back
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>

                @if($invoice->status === 'paid')
                <div class="alert alert-success">
                    <i class="fe fe-check-circle mr-2"></i>
                    <strong>Payment Received</strong> via {{ ucfirst($invoice->payment_method ?? 'N/A') }}
                    — Ref: {{ $invoice->payment_reference ?? 'N/A' }}
                    on {{ $invoice->paid_at ? \Carbon\Carbon::parse($invoice->paid_at)->format('d M Y') : 'N/A' }}
                </div>
                @elseif($invoice->status === 'unpaid')
                <div class="alert alert-info">
                    <h5><i class="fe fe-info mr-1"></i> Payment Options</h5>
                    <p class="mb-1"><strong>Option 1: M-Pesa STK Push</strong><br>
                        Click "Initiate M-Pesa STK Push" above to send a payment prompt to the client's phone.</p>
                    @if(config('services.mpesa.shortcode'))
                    <p class="mb-0"><strong>Option 2: Lipa na M-Pesa (Paybill)</strong><br>
                        Business Number: <b>{{ config('services.mpesa.shortcode') }}</b><br>
                        Account Number: <b>{{ $invoice->invoice_number }}</b><br>
                        Amount: KES {{ number_format($invoice->amount) }}
                    </p>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- STK Push Modal --}}
<div class="modal fade" id="stkPushModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fe fe-smartphone text-success mr-2"></i>
                    {{ $invoice->invoice_number }} — STK Push Payment
                </h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ route('super.invoices.stk-push', $invoice->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <img src="https://www.safaricom.co.ke/images/Lipanampesa.png"
                            alt="M-PESA" style="height:80px;width:auto;">
                    </div>

                    <div class="form-group mb-3">
                        <label>Amount to Pay <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-addon">KES</span>
                            <input type="number" class="form-control form-control-lg"
                                id="stk_amount" name="amount"
                                value="{{ $invoice->amount }}"
                                min="1" max="{{ $invoice->amount }}"
                                step="1" required>
                        </div>
                        <small class="text-muted">Max: KES {{ number_format($invoice->amount) }}</small>
                    </div>

                    <div class="form-group mb-3">
                        <label>M-Pesa Phone Number <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fe fe-phone"></i></span>
                            <input type="text" class="form-control"
                                id="stk_phone" name="phone"
                                value="{{ $invoice->org_phone }}"
                                placeholder="e.g. 0712345678 or 254712345678" required>
                        </div>
                    </div>

                    <div class="bg-light p-3 rounded mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Organization:</span>
                            <strong>{{ $invoice->org_name }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Invoice:</span>
                            <strong>{{ $invoice->invoice_number }}</strong>
                        </div>
                        <div class="d-flex justify-content-between pt-2 border-top">
                            <span class="h6 mb-0">Amount:</span>
                            <span class="h6 mb-0 text-primary" id="display_amount">
                                KES {{ number_format($invoice->amount) }}
                            </span>
                        </div>
                    </div>

                    <div class="alert alert-info p-2 mb-0">
                        <i class="fe fe-info mr-1"></i>
                        <small>An STK push will be sent to the phone above. The client must enter their M-Pesa PIN to complete payment.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="stk_submit_btn">
                        <i class="fe fe-smartphone mr-1"></i> Send STK Push — KES
                        <span id="submit_amount">{{ number_format($invoice->amount) }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#stk_amount').on('input', function() {
        var amount = $(this).val();
        var max = {{ $invoice->amount }};
        if (amount > max) { amount = max; $(this).val(max); }
        if (amount < 1) { amount = 1; $(this).val(1); }
        var formatted = parseFloat(amount).toLocaleString();
        $('#display_amount').text('KES ' + formatted);
        $('#submit_amount').text(formatted);
    });

    $('#stk_phone').on('input', function() {
        $(this).val($(this).val().replace(/\D/g, ''));
    });

    $('form').on('submit', function() {
        $('#stk_submit_btn').html('<i class="fe fe-loader mr-1"></i> Processing...').prop('disabled', true);
    });

    setTimeout(function() { $('.alert').fadeOut('slow'); }, 5000);
});
</script>
@endsection
