<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentControllerStoreRequest;
use App\Http\Requests\PaymentControllerUpdateRequest;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(Request $request): Response
    {
        $payments = Payment::all();

        return view('payment.index', compact('payments'));
    }

    public function create(Request $request): Response
    {
        return view('payment.create');
    }

    public function store(PaymentControllerStoreRequest $request): Response
    {
        $payment = Payment::create($request->validated());

        $request->session()->flash('payment.id', $payment->id);

        return redirect()->route('payments.index');
    }

    public function show(Request $request, Payment $payment): Response
    {
        return view('payment.show', compact('payment'));
    }

    public function edit(Request $request, Payment $payment): Response
    {
        return view('payment.edit', compact('payment'));
    }

    public function update(PaymentControllerUpdateRequest $request, Payment $payment): Response
    {
        $payment->update($request->validated());

        $request->session()->flash('payment.id', $payment->id);

        return redirect()->route('payments.index');
    }

    public function destroy(Request $request, Payment $payment): Response
    {
        $payment->delete();

        return redirect()->route('payments.index');
    }
}
