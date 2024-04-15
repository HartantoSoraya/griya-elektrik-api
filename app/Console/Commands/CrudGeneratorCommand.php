<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CrudGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create CRUD files: model, migration, controller, store request, update request, view.';

    public function handle()
    {
        $this->info('Creating magic... 🪄');

        $this->createModel();
        $this->createController();
        $this->createRequests();
        $this->modifyMigration();
        $this->modifyRepository();
        $this->createTest();
        $this->createFactory();
        $this->createViews();
        $this->addRoutes();
        $this->addSidebarMenu();

        $this->comment('Playground created successfully. Happy coding hugo! 🚀');
    }

    protected function createModel()
    {
        $name = $this->argument('name');
        $this->call('make:model', ['name' => $name, '-m' => true]);

        $modelPath = app_path("Models/{$name}.php");

        $modelContent = "<?php\n\n";
        $modelContent .= "namespace App\Models;\n\n";
        $modelContent .= "use Illuminate\Database\Eloquent\Factories\HasFactory;\n";
        $modelContent .= "use Illuminate\Database\Eloquent\Model;\n";
        $modelContent .= "use Illuminate\Database\Eloquent\SoftDeletes;\n";
        $modelContent .= "use App\Traits\UUID;\n\n";
        $modelContent .= "class {$name} extends Model\n";
        $modelContent .= "{\n";
        $modelContent .= "    use HasFactory, UUID, SoftDeletes;\n\n";
        $modelContent .= "    protected \$fillable = [\n";
        $modelContent .= "        // Add your columns here\n";
        $modelContent .= "    ];\n";
        $modelContent .= "}\n";

        file_put_contents($modelPath, $modelContent);
    }

    protected function createRequests()
    {
        $name = $this->argument('name');
        $this->call('make:request', ['name' => "Store{$name}Request"]);
        $this->call('make:request', ['name' => "Update{$name}Request"]);

        $storeRequestPath = app_path("Http/Requests/Store{$name}Request.php");
        $storeRequestContent = "<?php\n\n";
        $storeRequestContent .= "namespace App\Http\Requests;\n\n";
        $storeRequestContent .= "use Illuminate\Foundation\Http\FormRequest;\n\n";
        $storeRequestContent .= "class Store{$name}Request extends FormRequest\n";
        $storeRequestContent .= "{\n";
        $storeRequestContent .= "    /**\n";
        $storeRequestContent .= "     * Get the validation rules that apply to the request.\n";
        $storeRequestContent .= "     *\n";
        $storeRequestContent .= "     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>\n";
        $storeRequestContent .= "     */\n";
        $storeRequestContent .= "    public function rules()\n";
        $storeRequestContent .= "    {\n";
        $storeRequestContent .= "        return [\n";
        $storeRequestContent .= "            // Add your validation rules here\n";
        $storeRequestContent .= "        ];\n";
        $storeRequestContent .= "    }\n";
        $storeRequestContent .= "  public function attributes()\n";
        $storeRequestContent .= "    {\n";
        $storeRequestContent .= "        return [\n";
        $storeRequestContent .= "            // Add your attributes here\n";
        $storeRequestContent .= "        ];\n";
        $storeRequestContent .= "    }\n";
        $storeRequestContent .= "  public function messages()\n";
        $storeRequestContent .= "    {\n";
        $storeRequestContent .= "        return [\n";
        $storeRequestContent .= "            // Add your messages here\n";
        $storeRequestContent .= "        ];\n";
        $storeRequestContent .= "    }\n";
        $storeRequestContent .= "}\n";

        file_put_contents($storeRequestPath, $storeRequestContent);

        $updateRequestPath = app_path("Http/Requests/Update{$name}Request.php");
        $updateRequestContent = "<?php\n\n";
        $updateRequestContent .= "namespace App\Http\Requests;\n\n";
        $updateRequestContent .= "use Illuminate\Foundation\Http\FormRequest;\n\n";
        $updateRequestContent .= "class Update{$name}Request extends FormRequest\n";
        $updateRequestContent .= "{\n";
        $updateRequestContent .= "    /**\n";
        $updateRequestContent .= "     * Get the validation rules that apply to the request.\n";
        $updateRequestContent .= "     *\n";
        $updateRequestContent .= "     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>\n";
        $updateRequestContent .= "     */\n";
        $updateRequestContent .= "    public function rules()\n";
        $updateRequestContent .= "    {\n";
        $updateRequestContent .= "        return [\n";
        $updateRequestContent .= "            // Add your validation rules here\n";
        $updateRequestContent .= "        ];\n";
        $updateRequestContent .= "    }\n";
        $updateRequestContent .= "  public function attributes()\n";
        $updateRequestContent .= "    {\n";
        $updateRequestContent .= "        return [\n";
        $updateRequestContent .= "            // Add your attributes here\n";
        $updateRequestContent .= "        ];\n";
        $updateRequestContent .= "    }\n";
        $updateRequestContent .= "  public function messages()\n";
        $updateRequestContent .= "    {\n";
        $updateRequestContent .= "        return [\n";
        $updateRequestContent .= "            // Add your messages here\n";
        $updateRequestContent .= "        ];\n";
        $updateRequestContent .= "    }\n";
        $updateRequestContent .= "}\n";

        file_put_contents($updateRequestPath, $updateRequestContent);
    }

    protected function createController()
    {
        $name = $this->argument('name');

        $this->call('make:controller', ['name' => "Web/Admin/{$name}Controller", '--resource' => true]);

        $controllerPath = app_path("Http/Controllers/Web/Admin/{$name}Controller.php");

        $controllerContent =
            <<<'EOT'
            <?php

            namespace App\Http\Controllers\Web\Admin;
            
            use App\Http\Controllers\Controller;
            use App\Http\Requests\Store__namePascalCase__Request;
            use App\Http\Requests\Update__namePascalCase__Request;
            use App\Interfaces\__namePascalCase__RepositoryInterface;
            use RealRashid\SweetAlert\Facades\Alert as Swal;
            use Illuminate\Http\Request;
            class __namePascalCase__Controller extends Controller
            {
                protected $__nameCamelCase__Repository;
            
                public function __construct(__namePascalCase__RepositoryInterface $__nameCamelCase__Repository)
                {
                    $this->__nameCamelCase__Repository = $__nameCamelCase__Repository;
                }
            
                public function index(Request $request)
                {
                    $__nameCamelCasePlurals__ = $this->__nameCamelCase__Repository->getAll__nameCamelCasePlurals__();
                    
                    return view('pages.admin.__nameKebabCase__.index', compact('__nameCamelCasePlurals__'));
                }
            
                public function create()
                {
                    return view('pages.admin.__nameKebabCase__.create');
                }
            
                public function store(Store__namePascalCase__Request $request)
                {
                    $data = $request->validated();
                    $this->__nameCamelCase__Repository->create__namePascalCase__($data);
                    Swal::toast('__nameProperCase__ created successfully!', 'success')->timerProgressBar();
                    
                    return redirect()->route('admin.__nameKebabCase__.index');
                }
            
                public function show($id)
                {
                    $__nameCamelCase__ = $this->__nameCamelCase__Repository->get__namePascalCase__ById($id);
                    
                    return view('pages.admin.__nameKebabCase__.show', compact('__nameCamelCase__'));
                }
            
                public function edit($id)
                {
                    $__nameCamelCase__ = $this->__nameCamelCase__Repository->get__namePascalCase__ById($id);
                    
                    return view('pages.admin.__nameKebabCase__.edit', compact('__nameCamelCase__'));
                }
            
                public function update(Update__namePascalCase__Request $request, $id)
                {
                    $data = $request->validated();
                    $this->__nameCamelCase__Repository->update__namePascalCase__($data, $id);
                    Swal::toast('__nameProperCase__ updated successfully!', 'success')->timerProgressBar();
                    
                    return redirect()->route('admin.__nameKebabCase__.index');
                }
            
                public function destroy($id)
                {
                    $this->__nameCamelCase__Repository->delete__namePascalCase__($id);
                    Swal::toast('__nameProperCase__ deleted successfully!', 'success')->timerProgressBar();
                    
                    return redirect()->route('admin.__nameKebabCase__.index');
                }
            }
            EOT;

        $controllerContent = str_replace('__namePascalCase__', $name, $controllerContent);
        $controllerContent = str_replace('__nameCamelCase__', Str::camel($name), $controllerContent);
        $controllerContent = str_replace('__nameSnakeCase__', Str::snake($name), $controllerContent);
        $controllerContent = str_replace('__nameProperCase__', ucfirst(strtolower(preg_replace('/(?<=\\w)(?=[A-Z])/', ' ', $name))), $controllerContent);
        $controllerContent = str_replace('__nameKebabCase__', Str::kebab($name), $controllerContent);
        $controllerContent = str_replace('__nameCamelCasePlurals__', Str::camel(Str::plural($name)), $controllerContent);

        file_put_contents($controllerPath, $controllerContent);
    }

    protected function modifyMigration()
    {
        $name = $this->argument('name');
        $name = Str::snake($name);
        $name = Str::plural($name);
        $migration = database_path('migrations/'.date('Y_m_d_His').'_create_'.$name.'_table.php');

        $migrationContent = "<?php\n\n";
        $migrationContent .= "use Illuminate\Database\Migrations\Migration;\n";
        $migrationContent .= "use Illuminate\Database\Schema\Blueprint;\n";
        $migrationContent .= "use Illuminate\Support\Facades\Schema;\n\n";
        $migrationContent .= "return new class extends Migration\n";
        $migrationContent .= "{\n";
        $migrationContent .= "    /**\n";
        $migrationContent .= "     * Run the migrations.\n";
        $migrationContent .= "     */\n";
        $migrationContent .= "    public function up()\n";
        $migrationContent .= "    {\n";
        $migrationContent .= "        Schema::create('{$name}', function (Blueprint \$table) {\n";
        $migrationContent .= "            \$table->uuid('id')->primary();\n";
        $migrationContent .= "            // Add your columns here\n";
        $migrationContent .= "            \$table->softDeletes();\n";
        $migrationContent .= "            \$table->timestamps();\n";
        $migrationContent .= "        });\n";
        $migrationContent .= "    }\n\n";
        $migrationContent .= "    /**\n";
        $migrationContent .= "     * Reverse the migrations.\n";
        $migrationContent .= "     */\n";
        $migrationContent .= "    public function down()\n";
        $migrationContent .= "    {\n";
        $migrationContent .= "        Schema::dropIfExists('{$name}');\n";
        $migrationContent .= "    }\n";
        $migrationContent .= "};\n";

        file_put_contents($migration, $migrationContent);
    }

    protected function modifyRepository()
    {
        $name = $this->argument('name');
        $interfacePath = app_path("Interfaces/{$name}RepositoryInterface.php");
        $repositoryPath = app_path("Repositories/{$name}Repository.php");

        $interfaceContent = $this->generateInterfaceContent($name);

        $repositoryContent = $this->generateRepositoryContent($name);

        file_put_contents($interfacePath, $interfaceContent);
        file_put_contents($repositoryPath, $repositoryContent);

        $this->updateRepositoryServiceProvider($name);
    }

    protected function createTest()
    {
        $name = $this->argument('name').'Controller';
        $test = base_path("tests/Feature/{$name}Test.php");
        $testContent =
            <<<'EOT'
            <?php

            namespace Tests\Feature;

            use Illuminate\Support\Facades\Storage;
            use Tests\TestCase;

            class @name extends TestCase
            {
                public function setUp(): void
                {
                    parent::setUp();

                    Storage::fake('public');
                }

                //
            }
            EOT;
        $testContent = str_replace('@name', $name.'Test', $testContent);

        file_put_contents($test, $testContent);
    }

    protected function createFactory()
    {
        $name = $this->argument('name');
        $factory = database_path("factories/{$name}Factory.php");

        $factoryContent = "<?php\n\n";
        $factoryContent .= "namespace Database\Factories;\n\n";
        $factoryContent .= "use Illuminate\Database\Eloquent\Factories\Factory;\n";
        $factoryContent .= "use Illuminate\Support\Str;\n\n";
        $factoryContent .= "class {$name}Factory extends Factory\n";
        $factoryContent .= "{\n";
        $factoryContent .= "    /**\n";
        $factoryContent .= "     * Define the model's default state.\n";
        $factoryContent .= "     *\n";
        $factoryContent .= "     * @return array<string, mixed>\n";
        $factoryContent .= "     */\n";
        $factoryContent .= "    public function definition(): array\n";
        $factoryContent .= "    {\n";
        $factoryContent .= "        return [\n";
        $factoryContent .= "            // Define your default state here\n";
        $factoryContent .= "        ];\n";
        $factoryContent .= "    }\n";
        $factoryContent .= "}\n";

        file_put_contents($factory, $factoryContent);
    }

    protected function createViews()
    {
        $name = $this->argument('name');
        $normalName = $name;
        $name = Str::kebab($name);

        $viewsPath = resource_path("views/pages/admin/{$name}");

        if (! file_exists($viewsPath)) {
            mkdir($viewsPath, 0755, true);
        }

        $indexViewPath = $viewsPath.'/index.blade.php';
        $indexViewContent = $this->generateIndexViewContent($normalName);
        file_put_contents($indexViewPath, $indexViewContent);

        $createViewPath = $viewsPath.'/create.blade.php';
        $createViewContent = $this->generateCreateViewContent($normalName);
        file_put_contents($createViewPath, $createViewContent);

        $editViewPath = $viewsPath.'/edit.blade.php';
        $editViewContent = $this->generateEditViewContent($normalName);
        file_put_contents($editViewPath, $editViewContent);

        $showViewPath = $viewsPath.'/show.blade.php';
        $showViewContent = $this->generateShowViewContent($normalName);
        file_put_contents($showViewPath, $showViewContent);
    }

    protected function generateInterfaceContent($name)
    {
        $interfaceContent =
            <<<'EOT'
            <?php

            namespace App\Interfaces;
            
            interface __nameCamelCase__RepositoryInterface
            {
                public function getAll__namePascalCasePlurals__();
            
                public function get__nameCamelCase__ById(string $id);
            
                public function create__nameCamelCase__(array $data);
            
                public function update__nameCamelCase__(array $data, string $id);
            
                public function delete__nameCamelCase__(string $id);
            }            
            EOT;

        $interfaceContent = str_replace('__namePascalCase__', $name, $interfaceContent);
        $interfaceContent = str_replace('__namePascalCasePlurals__', Str::studly(Str::plural($name)), $interfaceContent);
        $interfaceContent = str_replace('__nameCamelCase__', Str::camel($name), $interfaceContent);
        $interfaceContent = str_replace('__nameSnakeCase__', Str::snake($name), $interfaceContent);
        $interfaceContent = str_replace('__nameProperCase__', ucfirst(strtolower(preg_replace('/(?<=\\w)(?=[A-Z])/', ' ', $name))), $interfaceContent);
        $interfaceContent = str_replace('__nameKebabCase__', Str::kebab($name), $interfaceContent);
        $interfaceContent = str_replace('__nameCamelCasePlurals__', Str::camel(Str::plural($name)), $interfaceContent);

        return $interfaceContent;
    }

    protected function generateRepositoryContent($name)
    {
        $repositoryContent =
            <<<'EOT'
            <?php

            namespace App\Repositories;
            
            use App\Interfaces\__namePascalCase__RepositoryInterface;
            use App\Models\__namePascalCase__;
            use Illuminate\Support\Facades\DB;
            
            class __namePascalCase__Repository implements __namePascalCase__RepositoryInterface
            {
                public function getAll__nameCamelCasePlurals__()
                {
                    return __namePascalCase__::all();
                }
            
                public function get__namePascalCase__ById(string $id)
                {
                    return __namePascalCase__::findOrFail($id);
                }
            
                public function create__namePascalCase__(array $data)
                {
                    DB::beginTransaction();
                    
                    try {
                        $__nameCamelCase__ = __namePascalCase__::create($data);
            
                        DB::commit();
            
                        return $__nameCamelCase__;
                    } catch (\Exception $e) {
                        DB::rollBack();
            
                        return $e->getMessage();
                    }
                }
            
                public function update__namePascalCase__(array $data, string $id)
                {
                    DB::beginTransaction();
            
                    try {
                        $__nameCamelCase__ = __namePascalCase__::findOrFail($id);
            
                        $__nameCamelCase__->update($data);
            
                        DB::commit();
            
                        return $__nameCamelCase__;
                    } catch (\Exception $e) {
                        DB::rollBack();
            
                        return $e->getMessage();
                    }
                }
            
                public function delete__namePascalCase__(string $id)
                {
                    DB::beginTransaction();
            
                    try {
                        __namePascalCase__::findOrFail($id)->delete();
            
                        DB::commit();
            
                        return true;
                    } catch (\Exception $e) {
                        DB::rollBack();
            
                        return $e->getMessage();
                    }
                }
            }        
            EOT;

        $repositoryContent = str_replace('__namePascalCase__', $name, $repositoryContent);
        $repositoryContent = str_replace('__nameCamelCase__', Str::camel($name), $repositoryContent);
        $repositoryContent = str_replace('__nameSnakeCase__', Str::snake($name), $repositoryContent);
        $repositoryContent = str_replace('__nameProperCase__', ucfirst(strtolower(preg_replace('/(?<=\\w)(?=[A-Z])/', ' ', $name))), $repositoryContent);
        $repositoryContent = str_replace('__nameKebabCase__', Str::kebab($name), $repositoryContent);
        $repositoryContent = str_replace('__nameCamelCasePlurals__', Str::camel(Str::plural($name)), $repositoryContent);

        return $repositoryContent;
    }

    protected function updateRepositoryServiceProvider($name)
    {
        $repositoryServiceProvider = app_path('Providers/RepositoryServiceProvider.php');
        $repositoryServiceProviderContent = file_get_contents($repositoryServiceProvider);

        $replacement = "\$this->app->bind(\App\Interfaces\\{$name}RepositoryInterface::class, \App\Repositories\\{$name}Repository::class);\n    }\n";

        $pattern = '/public function register\(\)\s*{([^}]*)}/s';
        $repositoryServiceProviderContent = preg_replace($pattern, "public function register() {\n$1$replacement", $repositoryServiceProviderContent, 1);

        file_put_contents($repositoryServiceProvider, $repositoryServiceProviderContent);
    }

    protected function generateIndexViewContent($name)
    {

        $content =
            <<<'EOT'
            <x-layouts.admin title="__nameTitleCase__">

                <x-ui.breadcumb-admin>
                    <li class="breadcrumb-item active" aria-current="page">__nameTitleCase__</li>
                </x-ui.breadcumb-admin>
            
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <x-ui.base-card>
                            <x-slot name="header">
                                <x-ui.base-button color="primary" type="button" href="{{ route('admin.__nameKebabCase__.create') }}">
                                    Tambah __nameTitleCase__
                                </x-ui.base-button>
                            </x-slot>
                            <x-ui.datatables>
                                <x-slot name="thead">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Aksi</th>
                                    </tr>
                                </x-slot>
                                <x-slot name="tbody">
                                    @foreach ($__nameCamelCasePlurals__ as $__nameCamelCase__)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $__nameCamelCase__->name }}</td>

                                        <td>
                                            <x-ui.base-button color="primary" type="button" href="{{ route('admin.__nameKebabCase__.show', $__nameCamelCase__->id) }}">
                                                Detail
                                            </x-ui.base-button>
            
                                            <x-ui.base-button color="warning" type="button" href="{{ route('admin.__nameKebabCase__.edit', $__nameCamelCase__->id) }}">
                                                Edit
                                            </x-ui.base-button>
            
                                            <form action="{{ route('admin.__nameKebabCase__.destroy', $__nameCamelCase__->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <x-ui.base-button color="danger" type="submit" onclick="return confirm('Yakin ingin menghapus?')">
                                                    Hapus
                                                </x-ui.base-button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </x-slot>
                            </x-ui.datatables>
                        </x-ui.base-card>
                    </div>
                </div>
            </x-layouts.admin>                
            EOT;

        $content = str_replace('__namePascalCase__', $name, $content);
        $content = str_replace('__nameCamelCase__', Str::camel($name), $content);
        $content = str_replace('__nameSnakeCase__', Str::snake($name), $content);
        $content = str_replace('__nameProperCase__', ucfirst(strtolower(preg_replace('/(?<=\\w)(?=[A-Z])/', ' ', $name))), $content);
        $content = str_replace('__nameTitleCase__', ucfirst(preg_replace('/(?<=\\w)(?=[A-Z])/', ' ', $name)), $content);
        $content = str_replace('__nameKebabCase__', Str::kebab($name), $content);
        $content = str_replace('__nameCamelCasePlurals__', Str::camel(Str::plural($name)), $content);

        return $content;
    }

    protected function generateCreateViewContent($name)
    {
        $content =
            <<<'EOT'
            <x-layouts.admin title="Tambah __nameTitleCase__">

                <x-ui.breadcumb-admin>
                    <li class="breadcrumb-item"><a href="{{ route('admin.__nameKebabCase__.index') }}">__nameTitleCase__</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah __nameTitleCase__</li>
                </x-ui.breadcumb-admin>
            
                <div class="row">
                    @if ($errors->any())
                    <div class="col-md-12 grid-margin">
                        <div class="alert alert-danger" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
            
                    <div class="col-md-12 grid-margin stretch-card">
                        <x-ui.base-card>
                            <x-slot name="header">
                                <h4 class="card-title">Tambah __nameTitleCase__</h4>
                            </x-slot>
                            <form action="{{ route('admin.__nameKebabCase__.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <x-forms.input label="Nama" name="name" id="name" /> 
                                <x-forms.input label="Slug" name="slug" id="slug" />    
                                <x-ui.base-button color="primary" type="submit">Simpan</x-ui.base-button>
                                <x-ui.base-button color="danger" href="{{ route('admin.__nameKebabCase__.index') }}">
                                    Kembali
                                </x-ui.base-button>
                            </form>
                        </x-ui.base-card>
                    </div>
                </div>
            
                @push('custom-scripts')
                <script>
                    const name = document.querySelector('#name');
                    const slug = document.querySelector('#slug');
            
                    name.addEventListener('keyup', function() {
                        const nameValue = name.value;
                        slug.value = nameValue.toLowerCase().split(' ').join('-');
                    });
                </script>
                @endpush
            </x-layouts.admin>
            EOT;

        $content = str_replace('__namePascalCase__', $name, $content);
        $content = str_replace('__nameCamelCase__', Str::camel($name), $content);
        $content = str_replace('__nameSnakeCase__', Str::snake($name), $content);
        $content = str_replace('__nameProperCase__', ucfirst(strtolower(preg_replace('/(?<=\\w)(?=[A-Z])/', ' ', $name))), $content);
        $content = str_replace('__nameTitleCase__', ucfirst(preg_replace('/(?<=\\w)(?=[A-Z])/', ' ', $name)), $content);
        $content = str_replace('__nameKebabCase__', Str::kebab($name), $content);
        $content = str_replace('__nameCamelCasePlurals__', Str::camel(Str::plural($name)), $content);

        return $content;
    }

    protected function generateEditViewContent($name)
    {
        $content =
            <<<'EOT'
            <x-layouts.admin title="Edit __nameTitleCase__">

                <x-ui.breadcumb-admin>
                    <li class="breadcrumb-item"><a href="{{ route('admin.__nameKebabCase__.index') }}">__nameTitleCase__</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit __nameTitleCase__</li>
                </x-ui.breadcumb-admin>
            
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <x-ui.base-card>
                            <x-slot name="header">
                                <h6>Edit __nameTitleCase__</h6>
                            </x-slot>
                            <form action="{{ route('admin.__nameKebabCase__.update', $__nameCamelCase__->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <x-forms.input label="Nama" name="name" id="name" :value="$__nameCamelCase__->name" />
                                <x-forms.input label="Slug" name="slug" id="slug" :value="$__nameCamelCase__->slug" />
            
                                <x-ui.base-button color="danger" href="{{ route('admin.__nameKebabCase__.index') }}">
                                    Kembali
                                </x-ui.base-button>
                                <x-ui.base-button color="primary" type="submit">
                                    Update __nameTitleCase__
                                </x-ui.base-button>
                            </form>
                        </x-ui.base-card>
                    </div>
                </div>

            @push('custom-scripts')
                <script>
                    const name = document.querySelector('#name');
                    const slug = document.querySelector('#slug');
        
                    name.addEventListener('keyup', function() {
                        const nameValue = name.value;
                        slug.value = nameValue.toLowerCase().split(' ').join('-');
                    });
                </script>
            @endpush  
            </x-layouts.admin>
            EOT;

        $content = str_replace('__namePascalCase__', $name, $content);
        $content = str_replace('__nameCamelCase__', Str::camel($name), $content);
        $content = str_replace('__nameSnakeCase__', Str::snake($name), $content);
        $content = str_replace('__nameProperCase__', ucfirst(strtolower(preg_replace('/(?<=\\w)(?=[A-Z])/', ' ', $name))), $content);
        $content = str_replace('__nameTitleCase__', ucfirst(preg_replace('/(?<=\\w)(?=[A-Z])/', ' ', $name)), $content);
        $content = str_replace('__nameKebabCase__', Str::kebab($name), $content);
        $content = str_replace('__nameCamelCasePlurals__', Str::camel(Str::plural($name)), $content);

        return $content;
    }

    protected function generateShowViewContent($name)
    {
        $content =
            <<<'EOT'
            <x-layouts.admin title="Detail __nameTitleCase__">

                <x-ui.breadcumb-admin>
                    <li class="breadcrumb-item"><a href="{{ route('admin.__nameKebabCase__.index') }}">__nameTitleCase__</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail __nameTitleCase__</li>
                </x-ui.breadcumb-admin>
            
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <x-ui.base-card>
                            <x-slot name="header">
                                <h4 class="card-title">Detail __nameTitleCase__</h4>
                            </x-slot>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Nama</th>
                                    <td>{{ $__nameCamelCase__->name }}</td>
                                </tr>
                                <tr>
                                    <th>Slug</th>
                                    <td>{{ $__nameCamelCase__->slug }}</td>
                                </tr>
                                <x-slot name="footer">
                                    <x-ui.base-button color="danger" href="{{ route('admin.__nameKebabCase__.index') }}">Kembali</x-ui.base-button>
                                </x-slot>
                            </table>
                        </x-ui.base-card>
                    </div>
                </div>
            </x-layouts.admin>
            EOT;

        $content = str_replace('__namePascalCase__', $name, $content);
        $content = str_replace('__nameCamelCase__', Str::camel($name), $content);
        $content = str_replace('__nameSnakeCase__', Str::snake($name), $content);
        $content = str_replace('__nameProperCase__', ucfirst(strtolower(preg_replace('/(?<=\\w)(?=[A-Z])/', ' ', $name))), $content);
        $content = str_replace('__nameTitleCase__', ucfirst(preg_replace('/(?<=\\w)(?=[A-Z])/', ' ', $name)), $content);
        $content = str_replace('__nameKebabCase__', Str::kebab($name), $content);
        $content = str_replace('__nameCamelCasePlurals__', Str::camel(Str::plural($name)), $content);

        return $content;
    }

    protected function addRoutes()
    {
        $name = $this->argument('name');

        $name = Str::kebab($name);
        $routes = base_path('routes/admin.php');

        $routeContent = "\nRoute::resource('{$name}', App\Http\Controllers\Web\Admin\\{$this->argument('name')}Controller::class);";

        file_put_contents($routes, $routeContent, FILE_APPEND);
    }

    protected function addSidebarMenu()
    {
        $name = $this->argument('name');
        $titleName = ucfirst(preg_replace('/(?<=\\w)(?=[A-Z])/', ' ', $name));
        $name = Str::kebab($name);

        $sidebar = resource_path('views/components/ui/admin-sidebar.blade.php');

        $sidebarContent = "\n<li class=\"nav-item {{ request()->is('admin/{$name}') ? ' active' : '' }}\">\n";
        $sidebarContent .= "    <a href=\"{{ route('admin.{$name}.index') }}\" class=\"nav-link\">\n";
        $sidebarContent .= "        <i class=\"link-icon\" data-feather=\"list\"></i>\n";
        $sidebarContent .= "        <span class=\"link-title\">{$titleName}</span>\n";
        $sidebarContent .= "    </a>\n";
        $sidebarContent .= "</li>\n";

        file_put_contents($sidebar, $sidebarContent, FILE_APPEND);
    }
}
