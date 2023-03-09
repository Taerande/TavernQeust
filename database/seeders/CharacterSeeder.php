<?php

namespace Database\Seeders;

use App\Models\Character;
use Illuminate\Database\Seeder;

class CharacterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $charSet = ["Bear-azshara", "Beardancing-azshara", "Blast-azshara", "Careful-azshara", "Ddqqddqq-azshara", "Divinestorm-azshara", "Dllute-azshara", "Doomknight-azshara", "Doydo-azshara", "Dungeon-azshara", "Ealc-azshara", "Eatos-azshara", "Estelion-azshara", "Estragon-azshara", "Forestnymph-azshara", "Frostdo-azshara", "Grarl-azshara", "Greenekim-azshara", "Hellfoxx-azshara", "Inf-azshara", "Isolated-azshara", "Junk-azshara", "Kleptomania-azshara", "Lalc-azshara", "Lewa-azshara", "Loose-azshara", "Maikelele-azshara", "Manute-azshara", "Moonjune-azshara", "Moonstorm-azshara", "Palc-azshara", "Pallux-azshara", "Piasku-azshara", "Pingxin-azshara", "Quasy-azshara", "Scales-azshara", "Segera-azshara", "Select-azshara", "Selly-azshara", "Skein-azshara", "Slaintroyard-azshara", "Srie-azshara", "Swiftmend-azshara", "Teddy-azshara", "Toddler-azshara", "Troyy-azshara", "Truzod-azshara", "Valc-azshara", "Vasteel-azshara", "Vesy-azshara", "Vetrez-azshara", "Volley-azshara", "Wetasstone-azshara", "Xkito-azshara", "Yoske-azshara", "Zamkl-azshara", "Zorde-azshara", "간지윤-azshara", "감귤춰컬릿-azshara", "거북이이-azshara", "고구마이야기-azshara", "골드로과소비-azshara", "구세주-azshara", "규와룡-azshara", "극세사이불-azshara", "금활-azshara", "긔이니-azshara", "기린목베개-azshara", "기쁘다드루오셧네-azshara", "까취킹-azshara", "까치킹-azshara", "꽉찬머리영상-azshara", "나진-azshara", "난호드아니지-azshara", "내츄럴세비-azshara", "노출-azshara", "노힐러사제-azshara", "늙고쿨한척함-azshara", "니달리뚜루-azshara", "니얼굴죽격-azshara", "닭뼈-azshara", "대곰탕-azshara", "도사민우-azshara", "드루잘해요-azshara", "딜하라고-azshara", "땜과수-azshara", "라돈맛-azshara", "로젠리터-azshara", "루멘카시미르-azshara", "룬체스매직-azshara", "마왕루야-azshara", "머여저색-azshara", "머용저색-azshara", "머즈커-azshara", "물빵갓-azshara", "발화주의-azshara", "밤과도토리-azshara", "방구석취준생-azshara", "법사재환이-azshara", "벤홀트-azshara", "보름달뜨는밤-azshara", "복수리입니다-azshara", "뿌뿌범-azshara", "서마격-azshara", "서초구죽음의기사-azshara", "송가네부대찌개-azshara", "수건빨래가귀찮아-azshara", "쉐도우선-azshara", "쉰상헌-azshara", "스마라-azshara", "슬레인트로이어드-azshara", "신양갱-azshara", "씹고수등장-azshara", "아린-azshara", "아이레이아-azshara", "안식-azshara", "알빠노-azshara", "앙마몬마스터-azshara", "약빤노루-azshara", "양준수대마왕-azshara", "양준수대장-azshara", "양준수의꽉쥔주먹-azshara", "언제잘할래용-azshara", "얼음혈죽-azshara", "얼첩자-azshara", "에스카네이드-azshara", "엠버시트린-azshara", "여우다아-azshara", "연대기의단편-azshara", "오늘을위해-azshara", "와이줴이-azshara", "왕도둑민우-azshara", "외로운늑대양준수-azshara", "용큼이-azshara", "우쿄캬쿄-azshara", "윈드파인더-azshara", "윤소향-azshara", "이게나라냥-azshara", "이현송-azshara", "인비저블썸띵-azshara", "인사부장님-azshara", "일산구흑마법사-azshara", "잔트수두붐은온다-azshara", "재라드무어-azshara", "재원짱-azshara", "재혁냥-azshara", "재혁드-azshara", "재혁술-azshara", "전사거푸-azshara", "전사미누-azshara", "정술고술토술-azshara", "정예-azshara", "조수회드-azshara", "주취-azshara", "죽기민우-azshara", "차빈-azshara", "쳔벼-azshara", "최강딜러김꽃님-azshara", "치마님-azshara", "카이셰르-azshara", "칼리모스의시종-azshara", "코륨주게-azshara", "콘마요-azshara", "퀸타렐리-azshara", "타미아르-azshara", "탱딜힐딜-azshara", "투명화-azshara", "튀동쨩-azshara", "파큼이-azshara", "펄스멍-azshara", "페리시치-azshara", "폴라드루-azshara", "퓨어냥꾼-azshara", "프리지아르-azshara", "피뢰침에연번크리-azshara", "하남시장-azshara", "하룬-azshara", "한물간사람-azshara", "한조츙-azshara", "핥아용-azshara", "호박머가리-azshara", "흑마하늘이-azshara", "흰큼이-azshara", "히뭉-azshara", "히잼-azshara", "힐큼이-azshara"];
        foreach ($charSet as $char) {
            Character::factory()->create([
                'name' => $char,
            ]);
        }
    }
}
