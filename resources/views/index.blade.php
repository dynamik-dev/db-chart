<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/mermaid@11.6.0/dist/mermaid.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
      .mermaid > svg {
        min-width: 600px;

      }
    </style>
</head>
<style type="text/tailwindcss">

</style>

<body class="bg-gray-900 text-white min-h-screen">
    <div class="container mx-auto p-4 flex flex-col items-center min-h-screen">
      <h1 class="text-2xl font-bold mb-4">Database Schema</h1>
      <div class="w-full max-w-4xl p-6 flex justify-center items-center min-h-[500px] mb-8">
          
            <div class="mermaid mx-auto max-w-3xl">
                {{ $schema }}
            </div>
        </div>
        <pre class="w-full max-w-2xl bg-gray-800 text-green-400 p-4 rounded-lg overflow-x-auto text-sm font-mono border border-gray-700 shadow">
{{ $schema }}
        </pre>
    </div>
    <script>
        mermaid.initialize({
            startOnLoad: true,
            theme: 'dark'
        });
    </script>
</body>

</html>
