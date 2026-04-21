# Quiz UI Improvements

## 1. Cache-First `showAll`

Rewrote the `#showAll` click handler to read entirely from `numberlist` and `questionCache` instead of making a database AJAX call. No DB query is issued when listing all questions.

**Before:** AJAX call to fetch all questions on every `showAll` click.  
**After:** Iterates `numberlist`, reads `questionCache[num]` for question/answer/category data directly.

---

## 2. CSS Width Fix for `#allQuestionsHere`

Bootstrap's `.row > *` selector applied gutter padding to `.eachItem` children, making the list narrower than the `#question` area.

**Fixes applied in `css/quiz.css`:**
```css
#allQuestionsHere {
    --bs-gutter-x: 0;
    margin-left: 0;
    margin-right: 0;
}
#allQuestionsHere > .eachItem {
    width: 100%;
    padding-left: 0;
    padding-right: 0;
}
```

---

## 3. Category Emojis

Added a `categoryEmoji` map and `getCatEmoji(name)` helper function inside `$(document).ready` in `quiz.html`.

**`getCatEmoji`** lowercases and trims the category name before lookup, so DB names like `machineLearning` match the key `machinelearning`.

Emojis are now shown in two places:
- **Category selector labels** (`showCategories`) — all levels (top category, `_0` duplicate, subcategories)
- **ShowAll question list** (`oneButtonHTML`) — prefixed to each question button using the question's category name looked up via `categorylist`

### Emoji Map

| Category | Emoji |
|---|---|
| history | 📜 |
| world history | 🌍 |
| china history | 🇨🇳 |
| history timeline | ⏳ |
| greek myths | ⚡ |
| astronomy | 🔭 |
| physics | ⚛️ |
| computer | 💻 |
| algorithms and database | 🧮 |
| machinelearning | 🤖 |
| sql | 🗄️ |
| java | ☕ |
| python | 🐍 |
| operating system | 🖥️ |
| linux | 🐧 |
| kdb/q | 📊 |
| c++ | ⚙️ |
| numpy_pandas_polars | 🐼 |
| politicseconomy | 🏛️ |
| economy | 📈 |
| health | 🏥 |
| biology | 🧬 |
| geography | 🗺️ |
| english | 📖 |
| finance | 💰 |
| wall_street_history | 🏦 |
| quant brainteasers | 🧠 |
| algotrading_execution | ⚡ |
| market_making | 📊 |
| quant knowledge | 📐 |
| 期权 | 💸 |
| math and statistics | 📐 |
| optimal control | 🎛️ |
| linear algebra | 🔢 |
| fin_mathstat | 📉 |

---

## Files Changed

| File | Change |
|---|---|
| `quiz.html` | Cache-only showAll; `categoryEmoji` map + `getCatEmoji()`; emoji in category labels and question list |
| `css/quiz.css` | Bootstrap gutter override for `#allQuestionsHere` and `.eachItem` |
