<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute を承認してください。',
    'accepted_if' => ':other が :value の場合、:attribute を承認してください。',
    'active_url' => ':attribute は有効なURLではありません。',
    'after' => ':attribute は :date より後の日付にしてください。',
    'after_or_equal' => ':attribute は :date 以降の日付にしてください。',
    'alpha' => ':attribute はアルファベットのみが利用できます。',
    'alpha_dash' => ':attribute はアルファベット、数字、ダッシュ（-）、アンダースコア（_）のみが利用できます。',
    'alpha_num' => ':attribute はアルファベットと数字のみが利用できます。',
    'any_of' => ':attribute の値が正しくありません。',
    'array' => ':attribute は配列にしてください。',
    'ascii' => ':attribute は半角の英数字および記号のみが利用できます。',
    'before' => ':attribute は :date より前の日付にしてください。',
    'before_or_equal' => ':attribute は :date 以前の日付にしてください。',
    'between' => [
        'array' => ':attribute は :min 個から :max 個の間でなければなりません。',
        'file' => ':attribute は :min KBから :max KBの間でなければなりません。',
        'numeric' => ':attribute は :min から :max の間でなければなりません。',
        'string' => ':attribute は :min 文字から :max 文字の間でなければなりません。',
    ],
    'boolean' => ':attribute は真偽値（true/false）でなければなりません。',
    'can' => ':attribute に権限のない値が含まれています。',
    'confirmed' => ':attribute の確認用入力が一致しません。',
    'contains' => ':attribute に必要な値が含まれていません。',
    'current_password' => 'パスワードが正しくありません。',
    'date' => ':attribute は有効な日付ではありません。',
    'date_equals' => ':attribute は :date と同じ日付にしてください。',
    'date_format' => ':attribute は :format 形式と一致しません。',
    'decimal' => ':attribute は小数点以下が :decimal 桁でなければなりません。',
    'declined' => ':attribute を拒否してください。',
    'declined_if' => ':other が :value の場合、:attribute を拒否してください。',
    'different' => ':attribute と :other は異なる必要があります。',
    'digits' => ':attribute は :digits 桁の数字にしてください。',
    'digits_between' => ':attribute は :min 桁から :max 桁の数字にしてください。',
    'dimensions' => ':attribute の画像サイズが無効です。',
    'distinct' => ':attribute に重複した値があります。',
    'doesnt_contain' => ':attribute に次の値を含めることはできません: :values',
    'doesnt_end_with' => ':attribute の末尾は次のいずれかであってはなりません: :values',
    'doesnt_start_with' => ':attribute の先頭は次のいずれかであってはなりません: :values',
    'email' => ':attribute は有効なメールアドレスの形式で入力してください。',
    'encoding' => ':attribute の文字コードは :encoding でなければなりません。',
    'ends_with' => ':attribute の末尾は次のいずれかでなければなりません: :values',
    'enum' => '選択された :attribute は無効です。',
    'exists' => '選択された :attribute は無効です。',
    'extensions' => ':attribute の拡張子は次のいずれかでなければなりません: :values',
    'file' => ':attribute はファイルでなければなりません。',
    'filled' => ':attribute を入力してください。',
    'gt' => [
        'array' => ':attribute は :value 個より多くなければなりません。',
        'file' => ':attribute は :value KBより大きくなければなりません。',
        'numeric' => ':attribute は :value より大きくなければなりません。',
        'string' => ':attribute は :value 文字より長くなければなりません。',
    ],
    'gte' => [
        'array' => ':attribute は :value 個以上でなければなりません。',
        'file' => ':attribute は :value KB以上でなければなりません。',
        'numeric' => ':attribute は :value 以上でなければなりません。',
        'string' => ':attribute は :value 文字以上でなければなりません。',
    ],
    'hex_color' => ':attribute は有効な16進数カラーコードでなければなりません。',
    'image' => ':attribute は画像ファイルを選択してください。',
    'in' => '選択された :attribute は無効です。',
    'in_array' => ':attribute は :other に存在しません。',
    'in_array_keys' => ':attribute には次のキーの少なくとも1つが含まれている必要があります: :values',
    'integer' => ':attribute は整数にしてください。',
    'ip' => ':attribute は有効なIPアドレスにしてください。',
    'ipv4' => ':attribute は有効なIPv4アドレスにしてください。',
    'ipv6' => ':attribute は有効なIPv6アドレスにしてください。',
    'json' => ':attribute は有効なJSON文字列にしてください。',
    'list' => ':attribute はリスト形式にしてください。',
    'lowercase' => ':attribute は小文字で入力してください。',
    'lt' => [
        'array' => ':attribute は :value 個より少なくなければなりません。',
        'file' => ':attribute は :value KBより小さくなければなりません。',
        'numeric' => ':attribute は :value より小さくなければなりません。',
        'string' => ':attribute は :value 文字より短くなければなりません。',
    ],    'lte' => [
        'array' => ':attribute は :value 個以下でなければなりません。',
        'file' => ':attribute は :value KB以下でなければなりません。',
        'numeric' => ':attribute は :value 以下でなければなりません。',
        'string' => ':attribute は :value 文字以下でなければなりません。',
    ],
    'mac_address' => ':attribute は有効なMACアドレスではありません。',
    'max' => [
        'array' => ':attribute は :max 個より多くすることはできません。',
        'file' => ':attribute は :max KBより大きくすることはできません。',
        'numeric' => ':attribute は :max より大きくすることはできません。',
        'string' => ':attribute は :max 文字以内で入力してください。',
    ],
    'max_digits' => ':attribute は :max 桁以内で入力してください。',
    'mimes' => ':attribute は以下のファイル形式で選択してください: :values',
    'mimetypes' => ':attribute は以下のファイル形式で選択してください: :values',
    'min' => [
        'array' => ':attribute は少なくとも :min 個必要です。',
        'file' => ':attribute は少なくとも :min KB以上にする必要があります。',
        'numeric' => ':attribute は :min 以上にする必要があります。',
        'string' => ':attribute は少なくとも :min 文字以上にする必要があります。',
    ],
    'min_digits' => ':attribute は少なくとも :min 桁以上にする必要があります。',
    'missing' => ':attribute は存在してはなりません。',
    'missing_if' => ':other が :value の場合、:attribute は存在してはなりません。',
    'missing_unless' => ':other が :value でない限り、:attribute は存在してはなりません。',
    'missing_with' => ':values が存在する場合、:attribute は存在してはなりません。',
    'missing_with_all' => ':values が存在する場合、:attribute は存在してはなりません。',
    'multiple_of' => ':attribute は :value の倍数でなければなりません。',
    'not_in' => '選択された :attribute は無効です。',
    'not_regex' => ':attribute の形式が正しくありません。',
    'numeric' => ':attribute は数字で入力してください。',
    'password' => [
        'letters' => ':attribute には少なくとも1つの文字を含める必要があります。',
        'mixed' => ':attribute には少なくとも1つの大文字と1つの小文字を含める必要があります。',
        'numbers' => ':attribute には少なくとも1つの数字を含める必要があります。',
        'symbols' => ':attribute には少なくとも1つの記号を含める必要があります。',
        'uncompromised' => '入力された :attribute はデータ漏洩に関与している可能性があります。別の :attribute を選択してください。',
    ],
    'present' => ':attribute が存在している必要があります。',
    'present_if' => ':other が :value の場合、:attribute が存在している必要があります。',
    'present_unless' => ':other が :value でない限り、:attribute が存在している必要があります。',
    'present_with' => ':values が存在する場合、:attribute が存在している必要があります。',
    'present_with_all' => ':values が存在する場合、:attribute が存在している必要があります。',
    'prohibited' => ':attribute の入力は禁止されています。',
    'prohibited_if' => ':other が :value の場合、:attribute の入力は禁止されています。',
    'prohibited_if_accepted' => ':other が承認されている場合、:attribute の入力は禁止されています。',
    'prohibited_if_declined' => ':other が拒否されている場合、:attribute の入力は禁止されています。',
    'prohibited_unless' => ':other が :values にない限り、:attribute の入力は禁止されています。',
    'prohibits' => ':attribute は :other の入力を禁止しています。',
    'regex' => ':attribute の形式が正しくありません。',
    'required' => ':attribute を入力してください。',
    'required_array_keys' => ':attribute には次の項目が含まれている必要があります: :values',
    'required_if' => ':other が :value の場合、:attribute を入力してください。',
    'required_if_accepted' => ':other が承認されている場合、:attribute を入力してください。',
    'required_if_declined' => ':other が拒否されている場合、:attribute を入力してください。',
    'required_unless' => ':other が :values にない限り、:attribute を入力してください。',
    'required_with' => ':values が存在する場合、:attribute を入力してください。',
    'required_with_all' => ':values が存在する場合、:attribute を入力してください。',
    'required_without' => ':values が存在しない場合、:attribute を入力してください。',
    'required_without_all' => ':values がいずれも存在しない場合、:attribute を入力してください。',
    'same' => ':attribute と :other は一致している必要があります。',
    'size' => [
        'array' => ':attribute は :size 個にしてください。',
        'file' => ':attribute は :size KBにしてください。',
        'numeric' => ':attribute は :size にしてください。',
        'string' => ':attribute は :size 文字にしてください。',
    ],
    'starts_with' => ':attribute は次のいずれかで始まる必要があります: :values',
    'string' => ':attribute は正しい形式（文字列）で入力してください。',
    'timezone' => ':attribute は有効なタイムゾーンを指定してください。',
    'unique' => 'この :attribute は既に登録されています。',
    'uploaded' => ':attribute のアップロードに失敗しました。',
    'uppercase' => ':attribute は大文字で入力してください。',
    'url' => ':attribute は有効なURLの形式で入力してください。',
    'ulid' => ':attribute は有効なULIDではありません。',
    'uuid' => ':attribute は有効なUUIDではありません。',


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'name' => 'お名前',
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'postal_code' => '郵便番号',
        'address' => '住所',
        'building' => '建物名',
        'image' => '画像ファイル',
        'price' => '販売価格',
        'description' => '商品の説明',
        'category_id' => 'カテゴリー',
        'condition' => '商品の状態',
    ],

];
