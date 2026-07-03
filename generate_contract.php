<?php
date_default_timezone_set("Asia/Tashkent");
require('fpdf186/fpdf.php');
require './auth/auth_check.php';
$client_name = $name = !empty($_POST['client_name']) ? $_POST['client_name'] : '________________________';
$client_paspurt = $name = !empty($_POST['client_paspurt']) ? $_POST['client_paspurt'] : '________________________';
$client_tel = $name = !empty($_POST['client_tel']) ? $_POST['client_tel'] : '_______________________';
$client_adress = $name = !empty($_POST['client_adress']) ? $_POST['client_adress'] : '________________________';

$total_sum = $name = !empty($_POST['total_sum']) ? $_POST['total_sum'] : '____________';
$days_sum = $name = !empty($_POST['days_sum']) ? $_POST['days_sum'] : '____________';
$contract_date = $name = !empty($_POST['contract_date']) ? $_POST['contract_date'] : date('Y-m-d H:i');
$contract_adress = $name = !empty($_POST['contract_adress']) ? $_POST['contract_adress'] : '____________';

$leader_name = $name = !empty($_POST['leader_name']) ? $_POST['leader_name'] : '____________';
$firm_tel = $name = !empty($_POST['firm_tel']) ? $_POST['firm_tel'] : '____________';
$firm_adress = $name = !empty($_POST['firm_adress']) ? $_POST['firm_adress'] : '____________';
$imzo = '________________________';

// PDF hosil qilish
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Times', 'B', 15);

// Matn
$pdf->MultiCell(0, 10, "Asbob-uskunalar va anjomlarni ijaraga berish shartnomasi\n", 0, 'C');
$pdf->Ln(5);

$pdf->SetFont('Times', 'B', 13);
$pdf->MultiCell(0, 10, "$contract_date                              SHARTNOMA raqami:                             $contract_adress\n\n", 0, 'C');

$pdf->Ln(2);

$pdf->SetFont('Times', '', 13);
$pdf->MultiCell(0, 7, "     Keyingi o'rinlarda \"Ijaraga beruvchi\" deb ataladigan ARENDA PRO nomidan ustav asosida faoliyat yuritadigan $leader_name ,bir tomondan va qurilishda faoliyat yuritadigan qurilish egasi  $client_name  tomondan ushbu shartnomani quyidagilar to'g'risida tuzishdi:\n ", 0, 'L');


$pdf->SetFont('Times', 'B', 15);
// Matn
$pdf->MultiCell(0, 10, "I. Shartnoma predmeti\n", 0, 'C');
$pdf->Ln(2);

$pdf->SetFont('Times', '', 13);
$pdf->MultiCell(0, 7, "     1.1 Ijara beruvchiga tegishli quyidagi asbob-uskunalar va anjomlarni (keyingi o'rinlarda \"mol-mulk\" deb ataladi) foydalanish uchun beradi, Ijaraga oluvchi esa qabul qilib oladi:", 0, 'L');

$pdf->SetFont('Times', '', 13);
$pdf->MultiCell(0, 7, "     1.2. Mazkur shartnoma O'zbekiston Respublikasining \"Ijara to'g'risida\"gi Qonuni talablaridan kelib chiqqan bo'lib, taraflarning o'zaro munosabatlari mazkur qonun doirasida tartibga solinadi. ", 0, 'L');

$pdf->SetFont('Times', 'B', 15);
// Matn
$pdf->MultiCell(0, 10, "II. Shartnoma bo'yicha to'lov narxlari va to'lov tartibi\n", 0, 'C');
$pdf->Ln(2);

$pdf->SetFont('Times', '', 13);
$pdf->MultiCell(0, 7, "     2.1 Shartnomaning 1.1 bandida ko'rsatilgan ijaraga berilayotgan mol-mulklarning umumiy summasi  $total_sum  so'mni tashkil qiladi. ", 0, 'L');

$pdf->SetFont('Times', '', 13);
$pdf->MultiCell(0, 7, "     2.2. Ko'rsatib o'tilgan mol-mulk Ijaraga oluvchi tomonidan beton quyish gisht terish, yoki boshqa qurilish ishlari maqsadida ishlarni amalga oshirish uchun foydalaniladi.", 0, 'L');

$pdf->SetFont('Times', '', 13);
$pdf->MultiCell(0, 7, "     2.3 Mol-mulk ushbu shartnoma imzolangan vaqtdan boshlab ijaraga berilgan hisoblanadi.", 0, 'L');

$pdf->SetFont('Times', '', 13);
$pdf->MultiCell(0, 7, "     2.4 Ijaraga    oluvchi   ilova  qilinayotgan  hisob-kitoblar    bo'yicha   kunlik umumiy summasi 1 sutkasiga   $days_sum  so'm miqdoridagi ijara haqini o'z vaqtida to'lash majburiyatini oladi.", 0, 'L');

$pdf->SetFont('Times', '', 13);
$pdf->MultiCell(0, 7, "Ijara haqi Ijaraga beruvchiningning klick yoki naxt pul shaklida, hisoblangan summani  kechikmay to'laydi.", 0, 'L');
$pdf->SetFont('Times', '', 13);
$pdf->MultiCell(0, 7, "To'lov oldindan yoki asbob uskunalar keltirib berilgan vaqtda amalga oshiriladi. Kelishilgan muddatdan kechiktirilganligi uchun Ijaraga oluvchi navbatdagi to'lov summasining kunlik 10 foizi miqdorida penya to'laydi.", 0, 'L');
$pdf->SetFont('Times', '', 13);
$pdf->MultiCell(0, 7, "     2.5 Ijara haqi miqdori tomonlarning kelishuviga ko'ra o'zgartirilishi mumkin. Markazlashtirilgan tartibda belgilanadigan narxlar va tariflar o'zgargan taqdirda ijara haqi miqdorlari tomonlardan birining talabiga ko'ra muddatidan oldin qayta ko'rib chiqilishi mumkin.", 0, 'L');


$pdf->SetFont('Times', 'B', 15);
$pdf->MultiCell(0, 10, "III. Taraflarning huquq va majburiyatlari\n", 0, 'C');
$pdf->Ln(2);

$pdf->SetFont('Times', '', 13);
$pdf->MultiCell(0, 7, "     3.1 Ijaraga beruvchining huquqlari.Ijaraga berilgan mol-mulkning \"ijaraga oluvchi\" tomonidan maqsadga muvofiq foydalanilayotganini, ularning soz holatdaligini tekshirish, dalolatnoma yoki boshqa hujjatlar tuzish;
    Ijara haqini tegishli muddatlarda to'lanishini talab qilish, \"ijaraga oluvchi\" bilan birgalikda hisob kitoblarni solishtirish dalolatnomalarini tuzish. 
    Shartnoma shartlarini o'zaro yoki sud orqali tuzish, o'zgartirish va bekor qilish. Ijaraga beruvchining boshqa huquqlari", 0, 'L');

$pdf->SetFont('Times', '', 13);
$pdf->MultiCell(0, 7, "     3.2 Ijaraga beruvchining majburiyatlari: Soz holatdagi va yaroqli mol-mulkni ijaraga berish; 
Shartnoma tuzilganidan so'ng kelishilgan vaqt ichida ijara obyektini qabul qilish-topshirish dalolatnomasi orqali \"ijaraga oluvchi\"ga topshirish;
Ijara obyektini sotishi yoki boshqacha tarzda begonalashtirishi to'g'risida  oldindan \"ijaraga oluvchi\"ga ma'lum qilish.Ijaraga beruvchining boshqa majburiyatlari", 0, 'L');

$pdf->SetFont('Times', '', 13);
$pdf->MultiCell(0, 7, "     3.3 Ijaraga oluvchining huquqlari:
Ijara obyektidan ushbu shartnomada belgilangan muddatda va tegishli maqsadga muvofiq foydalanish;
    Shartnomani bajarish, o'zgartirish va bekor qilish bilan bog'liq bo'lgan ma'lumotnomalar va boshqa xujjatlarni talab qilish va olish. Ijaraga beruvchi mol-mulkni undan zarur darajada foydalanish imkonini beradigan holatdaligini tekshirish. Ijaraga oluvchining boshqa huquqlari", 0, 'L');

$pdf->SetFont('Times', '', 13);
$pdf->MultiCell(0, 7, "     3.4 Ijaraga oluvchining majburiyatlari:
Ijaraga berilgan mol-mulkdan maqsadga muvofiq foydalanish;
    Mol-mulkdan foydalanish qoidalariga amal qilish;
\"ijaraga beruvchi\" ning yozma roziligisiz ijara obyekti bilan bog'liq huquq va majburiyatlarni uchinchi shaxslarga bermaslik, shuningdek ijara obyektini subijaraga bermaslik.
ijaraga olingan mol-mulkdan Ijaraga beruvchi buyurtmasiga ko'ra ishlarni bajarish uchun mo'ljallangan maqsadlar uchun foydalanish;
mol-mulkni to'liq ishga tayyor holatda saqlash.
    Ijaraga oluvchi ijaraga olingan mol-mulkning buzilganligi uchun javob beradi.
    Asbob-uskuna ijarasi shartnomasi to'xtatilganda Ijaraga oluvchi mol-mulkni Ijaraga beruvchiga qaysi holatda olgan bo'lsa, o'z holatda qaytarishi lozim.
    Tozalanmay yoki moylanmay olib kelingan asbob uskunalar uchun qo'shimcha haq, yani umumiy summani 30 foizida jarima qollaniladi.
Yo'qotilgan sindirilgan uskulanar uchun Arendo pro bazaviy hisoblash miqdori boyicha yetqazilgan zararni ijaraga oluvchi tomonidan to'lab  berilishi shart.

    Agar Ijaraga oluvchi ijaraga olingan mol-mulkni qaytarmagan bo'lsa yoxud o'z vaqtida qaytarmasa Ijaraga beruvchi muddati o'tkazib yuborilgan vaqt uchun mol-mulkdan foydalanganlik uchun haq to'lashni talab qilishga haqlidir. Ko'rsatib o'tilgan to'lov Ijaraga beruvchiga yetkazilgan zararni qoplamagan taqdirda Ijaraga beruvchi zararni qoplashni talab qilishi mumkin.
Ijaraga oluvchining boshqa majburiyatlari", 0, 'L');

$pdf->SetFont('Times', 'B', 15);
$pdf->MultiCell(0, 10, "IV. Boshqa shartlar\n", 0, 'C');
$pdf->Ln(2);

$pdf->SetFont('Times', '', 13);
$pdf->MultiCell(0, 7, "     4.1 Ijara shartnomasi shartlarining o'zgartirilishiga, uning bekor qilinishiga va tugatilishiga tomonlarning kelishuvi bilan yo'l qo'yiladi.
    Boshqa tomon shartnoma shartlarini buzgan taqdirda tomonlardan birining talabiga binoan shartnoma sud qaroriga ko'ra o'zgartirilishi yoki bekor qilinishi mumkin.
    Ijarachi muomalaga layoqatsiz deb topilgan taqdirda shartnoma O'zbekiston Respublikasi qonunchiligida belgilangan tartibda va shartlarda tugatiladi. Bu holda ijarachining oila a'zolaridan biri ijara shartnomasi tuzishda ustun huquqqa ega bo'ladi. Ijarachi sodir etgan jinoyati uchun kelgusida shartnomani bajara olishiga imkon bo'lmaydigan usulda jazolangan taqdirda ham ijara shartnomasi tugatiladi.
    
    4.2 Ijaraga olingan mol-mulk yana ijaraga (subijaraga) berilishi mumkin emas.
    4.3 Shartnoma bo'yicha majburiyatlar bajarilmaganligi yoki zarur darajada bajarilmaganligi, shartnomaning bir tomonlama o'zgartirilganligi yoki bekor qilinganligi uchun tomonlar yetkazilgan zararni, shu jumladan boy berilgan foydani amaldagi qonun hujjatlariga muvofiq qoplaydilar (ushbu shartnomada nazarda tutilgan jarima sanksiyalaridan tashqari).
    4.4 Tomonlarning ushbu shartnoma bilan tartibga solinmagan o'zaro munosabatlari qonun hujjatlari bilan tartibga solinadi.
    4.5 Ushbu shartnomadan kelib chiqadigan nizolar yuzasidan Qorako'l tuman sudi sudiga murojaat qilinadi.
    4.6 Mazkur shartnomaga tomonlar imzo chekkan kundan boshlab kuchga kiradi va kelishilgan kunda  ga qadar amalda bo'ladi.
    4.7 Ushbu shartnoma bir xil yuridik kuchga ega bo'lgan ikki nusxada, tomonlarning har biri uchun bir nusxadan tuzildi.", 0, 'L');

$pdf->SetFont('Times', 'B', 14);
$pdf->MultiCell(0, 10, "Taraflarning rekvizitlari\n", 0, 'C');
$pdf->Ln(2);

$pdf->SetFont('Times', 'B', 14);
$pdf->MultiCell(0, 10, "Ijaraga beruvchi:                                                Ijaraga oluvchi:", 0, 'C');
// $pdf->SetFont('Times', '', 13);
// $pdf->MultiCell(0, 6, "Manzil: $firm_adress                                             Manzil: $client_adress", 0, 'L');
// $pdf->SetFont('Times', '', 13);
// $pdf->MultiCell(0, 6, "To'lov: Naqd yoki Click                                          Paspurt(Seriasi): $client_paspurt", 0, 'L');

// Fontni kichikroq qilamiz
$pdf->SetFont('Times', '', 13);

// Ustun kengligi
$colWidth = 95;
$rowHeight = 8;

// Ma'lumotlar
$left = [
    'Manzil'     => $firm_adress,
    'To\'lov'    => 'Naqd yoki Click',
    'Telefon'    => $firm_tel,
    'F.I.O'      => $leader_name,
    'Imzo'       => $imzo
];

$right = [
    'Manzil'      => $client_adress,
    'Paspurt'     => $client_paspurt,
    'Telefon'     => $client_tel,
    'F.I.O'       => $client_name,
    'Imzo'       => $imzo
];

// Yagona label ro‘yxatini tuzamiz (ikki array'dan unique qiymatlar)
// Max labellar soni
$maxRows = max(count($left), count($right));
$leftKeys = array_keys($left);
$rightKeys = array_keys($right);

// Chiqarish
for ($i = 0; $i < $maxRows; $i++) {
    $labelLeft = $leftKeys[$i] ?? null;
    $labelRight = $rightKeys[$i] ?? null;

    $val1 = $labelLeft ? "$labelLeft: " . ($left[$labelLeft] ?? '________________') : '';
    $val2 = $labelRight ? "$labelRight: " . ($right[$labelRight] ?? '________________') : '';

    $pdf->Cell($colWidth, $rowHeight, $val1, 0, 0, 'L');
    $pdf->Cell($colWidth, $rowHeight, $val2, 0, 1, 'L');
}
// Yuklab berish
$pdf->Output('D', 'shartnoma.pdf');
 ?>

