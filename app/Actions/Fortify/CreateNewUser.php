<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input): User
    {
        // 1. バリデーションの実行（messagesメソッドを呼び出すように変更）
        Validator::make($input, $this->rules(), $this->messages())->validate();

        // 2. ユーザーの作成
        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }

    // バリデーションルールの定義
    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:20'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ];
    }

    // ★要件通りのエラーメッセージを定義
    protected function messages(): array
    {
        return [
            'name.required' => 'お名前を入力してください',
            'name.max'      => 'お名前は20文字以内で入力してください', 
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'email.unique' => 'メールアドレスは既に存在します',
            'password.required' => 'パスワードを入力してください',
            'password.min' => 'パスワードは8文字以上で入力してください',
            'password.confirmed' => 'パスワードと一致しません',
        ];
    }
}
