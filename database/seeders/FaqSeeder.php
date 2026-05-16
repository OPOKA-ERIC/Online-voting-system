<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            ['Is my vote anonymous?', 'Yes. Your identity is verified before voting, but your ballot is cryptographically separated from your identity the moment it is cast. Not even VoteSecure staff can link a vote back to a voter.', 1],
            ['What happens if I lose my login credentials?', 'Contact your election administrator. They can reset your access using the voter ID you were registered with. Your previously cast vote, if any, remains intact.', 2],
            ['Can I change my vote after submitting?', 'No. Once a ballot is submitted and recorded on the audit ledger it is final. This is by design — it mirrors the integrity of a physical ballot box.', 3],
            ['Who can see the results?', 'Results are published automatically when the election closes. Depending on the election settings, results may be visible to all voters in real time or only after polls close.', 4],
            ['Is VoteSecure compliant with data protection laws?', 'Yes. VoteSecure is GDPR compliant, SOC 2 Type II certified, and ISO 27001 aligned. Voter data is encrypted at rest and in transit and never sold to third parties.', 5],
            ['How long does it take to set up an election?', 'Most admins have their first election live in under 5 minutes. Create the election, add positions, upload your voter list, and you are ready to go.', 6],
        ];

        foreach ($faqs as [$question, $answer, $order]) {
            Faq::firstOrCreate(['question' => $question], [
                'answer'     => $answer,
                'sort_order' => $order,
            ]);
        }
    }
}
