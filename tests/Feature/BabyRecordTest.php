<?php

namespace Tests\Feature;

use App\Models\BabyRecord;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BabyRecordTest extends TestCase
{
    use RefreshDatabase;

    // 登録テスト
    public function test_登録できる()
    {
        $data = [
            'category'    => '授乳',
            'memo'        => 'テストメモ',
            'recorded_at' => '2026-07-01 10:00:00',
        ];

        $response = $this->post(route('baby_records.store'), $data);

        $response->assertRedirect(route('baby_records.index'));
        $this->assertDatabaseHas('baby_records', ['category' => '授乳']);
    }

    // 一覧テスト
    public function test_一覧が表示できる()
    {
        BabyRecord::create([
            'category'    => '睡眠',
            'memo'        => '昼寝',
            'recorded_at' => '2026-07-01 12:00:00',
        ]);

        $response = $this->get(route('baby_records.index'));

        $response->assertStatus(200);
        $response->assertSee('睡眠');
    }

    // 編集テスト
    public function test_編集できる()
    {
        $record = BabyRecord::create([
            'category'    => '排泄',
            'memo'        => '編集前',
            'recorded_at' => '2026-07-01 09:00:00',
        ]);

        $response = $this->put(route('baby_records.update', $record), [
            'category'    => '排泄',
            'memo'        => '編集後',
            'recorded_at' => '2026-07-01 09:00:00',
        ]);

        $response->assertRedirect(route('baby_records.index'));
        $this->assertDatabaseHas('baby_records', ['memo' => '編集後']);
    }

    // 削除テスト（論理削除）
    public function test_論理削除できる()
    {
        $record = BabyRecord::create([
            'category'    => 'その他',
            'memo'        => '削除テスト',
            'recorded_at' => '2026-07-01 08:00:00',
        ]);

        $response = $this->delete(route('baby_records.destroy', $record));

        $response->assertRedirect(route('baby_records.index'));
        $this->assertSoftDeleted('baby_records', ['id' => $record->id]);
    }
}