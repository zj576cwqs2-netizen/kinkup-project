public function rules()
{
    return [
        'title' => 'required|max:200',
        'description' => 'required|max:1000',
        'post_date' => 'nullable|date',
        'servings' => 'nullable|integer|min:1',
        'difficulty' => 'nullable|in:easy,medium,hard',
        'image' => 'nullable|image|max:5120', // 5MB
    ];
}