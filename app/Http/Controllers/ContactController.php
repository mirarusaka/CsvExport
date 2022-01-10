<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Imports\CsvImport;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContactController extends Controller
{
    public function index(Request $request){

        $contacts = Contact::select('contacts.*','conditions.name AS condition_name','designs.name AS design_name')
            ->where('contacts.status', 1)
            ->leftJoin('conditions', 'contacts.condition_id','=','conditions.id')
            ->leftJoin('designs', 'contacts.design_id','=','designs.id')
            ->orderBy('contacts.created_at', 'DESC')
            ->paginate(5);

        return view('index', compact('contacts'));
    }

    public function csvExport(Request $request) {

        $post = $request->all();
        $response = new StreamedResponse(function () use ($request, $post) {

            $stream = fopen('php://output','w');
            $contact = new Contact();

            // ヘッダー行を追加
            fputcsv($stream, $contact->csvHeader());

            $results = $contact->getCsvData($post['start_date'], $post['end_date']);

            if (empty($results[0])) {
                    fputcsv($stream, [
                        'データが存在しませんでした。',
                    ]);
            } else {
                foreach ($results as $row) {
                    fputcsv($stream, $contact->csvRow($row));
                }
            }
            fclose($stream);
        });
        $response->headers->set('Content-Type', 'application/octet-stream');
        $response->headers->set('content-disposition', 'attachment; filename='. $post['start_date'] . '〜' . $post['end_date'] . 'お問い合わせ一覧.csv');

        return $response;
    }

    public function csvImport(Request $request) {

        $filePath = $request->file('file');
        $file = new \SplFileObject($filePath);
        $file->setFlags(
            \SplFileObject::READ_CSV | // CSVとして行を読み込み
            \SplFileObject::READ_AHEAD | // 先読み／巻き戻しで読み込み
            \SplFileObject::SKIP_EMPTY | // 空行を読み飛ばす
            \SplFileObject::DROP_NEW_LINE // 行末の改行を読み飛ばす
        );

        $i = 0;

        // 一行ずつ処理
        foreach($file as $line)
        {
            if ($i != 0) {
                $contact = new Contact();
                $contact->condition_id = $line[0];
                $contact->design_id = $line[1];
                $contact->email = $line[2];
                $contact->tel_number = $line[3];
                $contact->fax_number = $line[4];
                $contact->zipcode = $line[5];
                $contact->pref = $line[6];
                $contact->city = $line[7];
                $contact->street = $line[8];
                $contact->surname = $line[9];
                $contact->name = $line[10];
                $contact->memo = $line[11];
                $contact->private_memo = $line[12];
                $contact->save();
            }
            $i++;
        }

        return redirect('/');
    }
}
