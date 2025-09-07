<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Message;
use App\Models\Chat;
use App\Models\User;
use App\Models\Ad;

class SystemMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chats = Chat::all();

        foreach ($chats as $chat) {
            // Check if a system message already exists for this chat
            $existingSystemMessage = Message::where('chat_id', $chat->id)
                                            ->where('system_message', true)
                                            ->first();

            if (!$existingSystemMessage) {
                // Assuming a system user exists or create one if necessary
                $systemUser = User::first(); // Or a dedicated system user

                if ($systemUser) {
                    Message::create([
                        'chat_id' => $chat->id,
                        'user_id' => $systemUser->id,
                        'content' => 'Não nos responsabilizamos por nenhuma negociação feita na plataforma. Utilize a plataforma com cautela.',
                        'system_message' => true,
                        'created_at' => '1970-01-01 00:00:00',
                        'updated_at' => '1970-01-01 00:00:00',
                    ]);
                }
            }
        }
    }
}
