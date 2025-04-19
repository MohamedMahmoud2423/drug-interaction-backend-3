<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Drug;

class ChatbotController extends Controller
{
    public function respond(Request $request)
    {
        $message = strtolower(trim($request->input('message')));
        $reply = "❓ Sorry, I couldn't understand that.";

        // 🌟 Step 0: Keyword-based conversational responses
        $greetings = [
            'hello', 'hi', 'hey', 'good morning', 'good evening', 'how are you', 'ازيك', 'السلام عليكم',
        ];

        $helpKeywords = [
            'help', 'need help', 'ساعدني', 'مساعدة', 'اه ساعدني', 'yes i need help', 'i need assistance',
        ];

        $howAreYouKeywords = [
            'how are you', 'عامل ايه', 'ازيك', 'كيف الحال', 'اخبارك',
        ];

        foreach ($greetings as $greet) {
            if (str_contains($message, $greet)) {
                $reply = "👋 Hi there! How can I assist you today?";
                if (in_array($greet, ['ازيك', 'عامل ايه', 'كيف الحال', 'اخبارك', 'how are you'])) {
                    $reply = "😊 الحمد لله، إزيك انت؟ ممكن أساعدك في حاجة تخص الأدوية؟";
                }
                return response()->json(['reply' => $reply]);
            }
        }

        foreach ($helpKeywords as $help) {
            if (str_contains($message, $help)) {
                $reply = "🧐 Sure, let me know what you need help with! Do you want to check drug interactions, contraindications, or something else?";
                return response()->json(['reply' => $reply]);
            }
        }

       

        // Step 1: Get all known drug names
        $allDrugNames = Drug::pluck('name')->map(fn($name) => strtolower($name))->toArray();

        // Step 2: Extract words from message
        preg_match_all('/\b[a-zA-Z]+\b/', $message, $matches);
        $words = array_map('strtolower', $matches[0]);

        // Step 3: Match only known drug names
        $matchedDrugs = [];
        foreach ($words as $word) {
            if (in_array($word, $allDrugNames)) {
                $matchedDrugs[] = ucfirst($word);
            }
        }
        $drugNames = array_unique($matchedDrugs);

        // Step 4: Check for drug interaction if 2 or more drugs
        if (count($drugNames) >= 2) {
            [$drug1, $drug2] = array_slice($drugNames, 0, 2);

            $drug = Drug::where('name', $drug1)->first();

            if ($drug) {
                $interactionsArray = array_map('trim', explode(',', strtolower($drug->drug_drug_interactions ?? '')));
                $drug2Lower = strtolower($drug2);

                if (in_array($drug2Lower, $interactionsArray)) {
                    $reply = "🔎 <strong>Drug Interaction Check</strong><br><br>"
                        . "✅ Yes, there's an interaction between <strong>$drug1</strong> and <strong>$drug2</strong>.<br><br>"
                        . "🧬 <strong>Interaction Details:</strong><br>"
                        . "• <strong>$drug2</strong> is listed as interacting with <strong>$drug1</strong>.<br>"
                        . "• ⚠️ <strong>Risk Description:</strong> " . ($drug->risk_description ?? 'Not specified') . "<br>"
                        . "• 🧪 <strong>Severity Level:</strong> " . ($drug->severity ?? 'Unknown') . "<br>"
                        . "• ⛔ <strong>Contraindications:</strong><br>• " . str_replace(',', "<br>•", $drug->contraindications ?? 'None');
                } else {
                    $reply = "❌ No interaction found between <strong>$drug1</strong> and <strong>$drug2</strong>.";
                }
            } else {
                $reply = "❌ Drug '<strong>$drug1</strong>' not found.";
            }

            return response()->json(['reply' => $reply]);
        }

        // Step 5: If single drug mentioned, return its info
        if (count($drugNames) === 1) {
            $drug = Drug::where('name', $drugNames[0])->first();
            if ($drug) {
                $reply = "💊 <strong>Drug Information: {$drug->name}</strong><br><br>"
                       . "⛔ <strong>Contraindications:</strong><br>• " . str_replace(',', "<br>•", $drug->contraindications ?? 'None') . "<br><br>"
                       . "🔗 <strong>Known Drug Interactions:</strong><br>• " . str_replace(',', "<br>•", $drug->drug_drug_interactions ?? 'None') . "<br><br>"
                       . "🧪 <strong>Severity Level:</strong> {$drug->severity}<br><br>"
                       . "⚠️ <strong>Risk Description:</strong> " . ($drug->risk_description ?? 'Not specified') . "<br><br>";
            } else {
                $reply = "❌ Drug '<strong>{$drugNames[0]}</strong>' not found.";
            }

            return response()->json(['reply' => $reply]);
        }

        return response()->json(['reply' => $reply]);
    }
}
