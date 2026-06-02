<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品の出品 - coachtechフリマ</title>
</head>
<body style="margin: 0; background-color: #fff; font-family: sans-serif;">

    @include('layouts.header')

    <div style="max-width: 600px; margin: 0 auto; padding: 40px 20px; font-family: sans-serif;">
        <h1 style="text-align: center; font-size: 1.8em; font-weight: bold; margin-bottom: 30px; color: #111;">商品の出品</h1>

        <!-- 成功・エラーメッセージの表示エリア -->
        @if (session('message'))
            <div style="background-color: #d4edda; color: #155724; padding: 12px; margin-bottom: 25px; border: 1px solid #c3e6cb; border-radius: 4px; font-size: 0.95em;">
                {{ session('message') }}
            </div>
        @endif
        @if ($errors->any())
            <div style="background-color: #f8d7da; color: #721c24; padding: 12px; margin-bottom: 25px; border: 1px solid #f5c6cb; border-radius: 4px; font-size: 0.95em;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('item.store') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 35px;">
            @csrf

            <!-- 📸 商品画像アップロードエリア -->
            <div>
                <label style="display: block; font-weight: bold; margin-bottom: 10px; color: #333;">商品画像</label>
                <div style="border: 1px dashed #ccc; border-radius: 4px; padding: 20px; text-align: center; background-color: #fff; position: relative; min-height: 180px; display: flex; flex-direction: column; justify-content: center; align-items: center; gap: 15px;">

                    <!-- 💡 選択した画像を大きく四角く表示するプレビュー枠 -->
                    <img id="image-preview" src="" alt="プレビュー" style="display: none; max-width: 100%; max-height: 200px; object-fit: contain; border-radius: 4px;">

                    <label for="image" style="display: inline-block; border: 1px solid #ff4d4f; color: #ff4d4f; background: #fff; padding: 6px 16px; border-radius: 4px; font-size: 0.85em; font-weight: bold; cursor: pointer; transition: 0.2s;">
                        画像を選択する
                    </label>
                    <input type="file" name="image" id="image" accept="image/jpeg,image/png" style="display: none;" onchange="previewImage(this)">

                    <div id="image-name" style="font-size: 0.85em; color: #666;"></div>
                </div>
            </div>

            <!-- 🏷️ 商品の詳細セクション -->
            <div>
                <h2 style="font-size: 1.2em; font-weight: bold; color: #666; border-bottom: 1px solid #eee; padding-bottom: 8px; margin-bottom: 20px;">商品の詳細</h2>

                <!-- カテゴリー（バッジ風） -->
                <div style="margin-bottom: 25px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 12px; color: #333;">カテゴリー</label>
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        @foreach($categories as $category)
                            <label style="position: relative; cursor: pointer; margin-bottom: 5px;">
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                    {{ is_array(old('categories')) && in_array($category->id, old('categories')) ? 'checked' : '' }}
                                    style="position: absolute; opacity: 0; width: 0; height: 0;"
                                    class="category-checkbox"
                                    onchange="toggleCategoryStyle(this)"
                                >
                                <span class="category-badge" style="display: inline-block; border: 1px solid #ff4d4f; color: #ff4d4f; background-color: #fff; padding: 6px 18px; border-radius: 20px; font-size: 0.85em; font-weight: bold; transition: all 0.2s; user-select: none;">
                                    {{ $category->content }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- 商品の状態（コンディション） -->
                <div style="margin-bottom: 25px;">
                    <label for="condition_id" style="display: block; font-weight: bold; margin-bottom: 10px; color: #333;">商品の状態</label>
                    <select name="condition_id" id="condition_id" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1em; background-color: #fff;">
                        <option value="">選択してください</option>
                        @foreach($conditions as $condition)
                            <option value="{{ $condition->id }}" {{ old('condition_id') == $condition->id ? 'selected' : '' }}>
                                {{ $condition->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- 📝 商品名と説明セクション -->
            <div>
                <h2 style="font-size: 1.2em; font-weight: bold; color: #666; border-bottom: 1px solid #eee; padding-bottom: 8px; margin-bottom: 20px;">商品名と説明</h2>

                <!-- 商品名 -->
                <div style="margin-bottom: 25px;">
                    <label for="name" style="display: block; font-weight: bold; margin-bottom: 10px; color: #333;">商品名</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1em; box-sizing: border-box;">
                </div>

                <!-- ブランド名 -->
                <div style="margin-bottom: 25px;">
                    <label for="brand" style="display: block; font-weight: bold; margin-bottom: 10px; color: #333;">ブランド名</label>
                    <input type="text" name="brand" id="brand" value="{{ old('brand') }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1em; box-sizing: border-box;">
                </div>

                <!-- 商品の説明 -->
                <div style="margin-bottom: 25px;">
                    <label for="description" style="display: block; font-weight: bold; margin-bottom: 10px; color: #333;">商品の説明</label>
                    <textarea name="description" id="description" rows="5" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1em; box-sizing: border-box; resize: vertical;">{{ old('description') }}</textarea>
                </div>
            </div>

            <!-- 💰 販売価格セクション -->
            <div>
                <h2 style="font-size: 1.2em; font-weight: bold; color: #666; border-bottom: 1px solid #eee; padding-bottom: 8px; margin-bottom: 20px;">販売価格</h2>
                <div style="margin-bottom: 25px;">
                    <label for="price" style="display: block; font-weight: bold; margin-bottom: 10px; color: #333;">販売価格</label>
                    <div style="position: relative; display: flex; align-items: center;">
                        <span style="position: absolute; left: 15px; color: #333; font-weight: bold; font-size: 1.1em;">¥</span>
                        <input type="number" name="price" id="price" value="{{ old('price') }}" placeholder="0" style="width: 100%; padding: 10px 10px 10px 35px; border: 1px solid #ccc; border-radius: 4px; font-size: 1em; box-sizing: border-box;">
                    </div>
                </div>
            </div>

            <!-- 🚀 出品ボタン -->
            <button type="submit" style="width: 100%; background-color: #ff4d4f; color: #fff; border: none; padding: 14px; border-radius: 4px; font-size: 1.1em; font-weight: bold; cursor: pointer; transition: 0.2s;" onmouseover="this.style.backgroundColor='#e03e41'" onmouseout="this.style.backgroundColor='#ff4d4f'">
                出品する
            </button>

        </form>
    </div>

    <!-- 💡 JavaScriptによるプレビューとバッジ選択のインタラクション制御 -->
    <script>
        // 画像プレビュー処理
        function previewImage(input) {
            const preview = document.getElementById('image-preview');
            const nameDiv = document.getElementById('image-name');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
                nameDiv.textContent = input.files[0].name;
            } else {
                preview.src = "";
                preview.style.display = 'none';
                nameDiv.textContent = "";
            }
        }

        // カテゴリバッジの選択スタイル切り替え
        function toggleCategoryStyle(checkbox) {
            const badge = checkbox.nextElementSibling;
            if (checkbox.checked) {
                badge.style.backgroundColor = '#ff4d4f';
                badge.style.color = '#fff';
            } else {
                badge.style.backgroundColor = '#fff';
                badge.style.color = '#ff4d4f';
            }
        }

        // 画面読み込み時に最初からチェックが入っているバッジの色を初期化
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.category-checkbox').forEach(function(checkbox) {
                toggleCategoryStyle(checkbox);
            });
        });
    </script>
</body>
</html>
