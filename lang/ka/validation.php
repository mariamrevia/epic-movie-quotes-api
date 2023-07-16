<?php

return [
    'attributes' => [
        'username' => 'მომხმარებლის სახელი',
        'email'    => 'ელ-ფოსტა',
        'password' => 'პაროლი',
    ],
    'required'                          => 'აუცილებელია მიუთითოთ :attribute',
    'unique'                            => ' :attribute გამოყენებულია',
    'valid-username'                    => 'მომხმარებლის სახელი უნდა იყოს ვალიდური ელ-ფოსტა ან სახელი',
    'email'                             => 'მოწოდებული ინფორმაცია არასწორია',
    'confirmed'                         => ' :attribute-ის ველი არ ემთხვევა',

    'min' => [
        'string'=> ':attribute უნდა შედგებოდეს მინიმუმ :min სიმბოლოსგან.',
    ],
];
