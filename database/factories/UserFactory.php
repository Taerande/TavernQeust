<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'photoUrl' => 'https://filestore.community.support.microsoft.com/api/images/39da0bc2-ad7d-434d-bc10-fb80d3a85b7c?upload=true&fud_access=rhYinQu9k%2FQ7lDpdCsGkl3eusmFMeQelfHau4vFjY8lur4WJxfiEK7M3p4%2Bs9FkBPy4gjPk1BpzKedTB0Zjh%2BzCRtDd6jCa%2FyokBDwISGOaLz2NNyurtbpNCCvuSAxDElHG%2Fn6DLSEvx6me%2BhAe45FygWyaM13aMFCXjX4XLEtrFNbsPa%2FGiecjaxSm1TrCn7byPD7Xbl784bRlFBb7eoOOKGC9nD%2BueSUutgrnNLeXJ9skPj7ep8O2Q5PU44xyClhCfRIe%2FmH0XGT4OcUitdfpThWlztcFKvf4fPF64znlOP%2BFISdMgg0L%2FgqrscGUghafF3Mn74KmcgDp5l7d4TCoCvo%2Fr12TbFED04B4i%2B40%3D',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
