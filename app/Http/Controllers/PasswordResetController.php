<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Mail\CodeMail;
use App\Models\Utilisateur;
use App\Models\PasswordResetCode;

class PasswordResetController extends Controller
{
    /**
     * Affiche le formulaire de réinitialisation par email.
     */
    public function showForgotForm()
    {
        return view('Auth.forgot-password');
    }

    /**
     * Envoie le code par email.
     */
    public function sendCode(Request $request)
    {
        //dd('code envoyer');
        $request->validate(['email' => 'required|email']);

        $code = random_int(100000, 999999);

        PasswordResetCode::create([
            'email' => $request->email,
            'code' => $code,
            'expires_at' => now()->addMinutes(15),
        ]);

        Mail::to($request->email)->send(new CodeMail($code));

        //return redirect()->route('verify.code')->with('email', $request->email);
        session([
            'email' => $request->email,
            'code' => $code,
        ]);

        return redirect()->route('verify.code');
    }

    /**
     * Affiche le formulaire de saisie du code reçu.
     */
    public function showVerifyForm()
    {
        return view('Auth.verify-code');
    }

    /**
     * Vérifie que le code est correct.
     */


    // ...

    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code'  => 'required',
        ], [
            'code.required' => 'entre le bon code',
        ]);

        $record = PasswordResetCode::where('email', $request->email)
            ->where('code', $request->code)
            ->where('expires_at', '>', now())
            ->first();
        // Session persistée pour la suite

        session(['email' => $request->email]);
        session(['code' => $request->code]);
        if ($record) {
            return view('Auth.reset-password', [
                'email' => $request->email,
                'code' => $request->code,
            ]);
        }

        // ✅ Code invalide : déclenche l’erreur ici
        return back()->withErrors(['code' => 'veuillez entrer le bon code'])->withInput();


        //return back()->withErrors(['code' => 'veuillez entrer le bon code'])->withInput();

    }

    /**
     * Affiche le formulaire pour définir le nouveau mot de passe.
     */
    public function showResetForm()
    {
        //dd(session()->all());

        return view('Auth.reset-password', [
            'email' => session('email'),
            'code' => session('code')
        ]);
    }

    /**
     * Met à jour le mot de passe de l'utilisateur.
     */

    public function resetPassword(Request $request)
    {
        // dd(session()->all());

        // 🔍 Log des données reçues
        Log::info('🔄 Données reçues pour réinitialisation', $request->all());

        // ✅ Validation avec messages personnalisés
        $request->validate([
            'email' => 'required|email',
            'code' => 'required',
            'password' => 'required|min:8|confirmed',
        ], [
            'password.confirmed' => ' Les mots de passe ne correspondent pas.',
            'password.required' => '❌ Le mot de passe est requis.',
            'email.email' => '❌ Email invalide.',
            'email.required' => '❌ L’email est requis.',
            'code.required' => '❌ Le code est requis.',
        ]);



        // 🔍 Vérification utilisateur
        $user = Utilisateur::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => '❌ Utilisateur introuvable'])->withInput();
        }

        // 🔍 Vérification du code
        $codeEntry = PasswordResetCode::where('email', $request->email)
            ->where('code', $request->code)
            ->where('expires_at', '>', now())
            ->first();

        if ($codeEntry->expires_at < now()) {
            return redirect()->route('password.reset.form')->withErrors([
                'code' => '❌ Ce code a expiré. Veuillez demander un nouveau code.'
            ])->withInput();
        }
        // 🔐 Mise à jour du mot de passe
        $user->password = Hash::make($request->password);
        $user->save();

        // 🧹 Nettoyage du code
        PasswordResetCode::where('email', $request->email)->delete();

        // 📋 Log de succès
        Log::info('✅ Mot de passe réinitialisé pour : ' . $user->email);

        // 🔁 Redirection avec message
        return redirect()->route('login')->with('status', '✅ Mot de passe mis à jour avec succès');
    }
}
