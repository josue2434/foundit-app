<?php

use App\Http\Controllers\Almacen\AlmacenesController;
use App\Http\Controllers\Almacen\MaterialesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Users\createUserController;
use App\Http\Controllers\Users\getUsersController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

Route::get('/', function () {
    //return view('welcome');
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('session.auth')->name('dashboard');

Route::middleware(['session.auth'])->group(function () {


// ===== RUTAS PARA ALMACENES (SOLO VISTAS - SIMPLIFICADAS) =====
    // IMPORTANTE: Reemplaza completamente el bloque de rutas de 'almacenes' si ya existe.
    Route::prefix('almacenes')->group(function () {
        // 1. Ruta para la vista de creación (estática) - DEBE IR PRIMERO
        Route::get('/crear', function () {
            return view('almacen.crear-almacen');
        })->name('almacenes.crear'); // Nombre de ruta: almacenes.crear

        // 2. Ruta para la vista de índice (listado principal)
        Route::get('/', function () {
            return view('almacen.index-almacen');
        })->name('almacenes.index'); // Nombre de ruta: almacenes.index
        
        // 3. Ruta para la vista de edición (con parámetro dinámico {id})
        Route::get('/{id}/edit', function ($id) {
            // Datos de ejemplo para que la vista se renderice sin funcionalidad de backend
            $almacen = [
                'id' => $id,
                'nombre' => 'Almacén de Ejemplo (ID: ' . $id . ')',
                'direccion' => 'Dirección de Ejemplo ' . $id,
                'cantidad_estantes' => 10,
            ];
            return view('almacen.edit-almacen', ['almacen' => $almacen]);
        })->name('almacenes.edit'); // Nombre de ruta: almacenes.edit
    });









    //  RUTAS DE PRODUCTOS 
    Route::get('/critical-products', function () {
        return view('products.critical_products');
    })->name('critical.products');

    Route::get('/expensive-products', function () {
        return view('products.expensive_products');
    })->name('expensive.products');

    Route::get('/total-products', function () {
        return view('products.total_products');
    })->name('total.products');

    //  RUTAS DEL MÓDULO DE ÁREA (INVENTARIO) 
    // Surtido (ahora apunta a una vista existente de surtido)
    Route::get('/part-with-material', function () {
        return view('inventory.part_with_material');
    })->name('part.with.material');

    // Almacén
    /* Route::get('/stock-view', function () {
        return view('inventory.stock_view');
    })->name('stock.view'); */
    Route::get('/stock-view',[MaterialesController::class, 'getAllmateriales'])->name('stock.view'); 
    Route::get('/view-stock', [MaterialesController::class, 'gestionEmbarques'])->name('view-stock'); // Alias para compatibilidad con el nombre anterior en la barra lateral
    
    // Búsqueda de materiales
    Route::get('/materiales/buscar', [MaterialesController::class, 'buscarMaterialesPorNombre'])->name('materiales.buscar');

    // Historial de movimientos de un material (JSON)
    Route::get('/materiales/{id}/movimientos', [MaterialesController::class, 'historialMovimientos'])->name('materiales.movimientos');

    // Recibo/Entrada
    Route::get('/gestion-embarques', function () {
        return view('inventory.gestion_embarques');
    })->name('gestion.embarques');
    // Alias para compatibilidad con el nombre anterior en la barra lateral
    Route::get('/inventory-stock', function () {
        return view('inventory.gestion_embarques');
    })->name('Inventorystock');

    // Vistas específicas de formularios de inventario
    Route::get('/register-form', function () {
        return view('inventory.register_form');
    })->name('register_form');

    Route::get('/register-location', function () {
        return view('inventory.register_location');
    })->name('register_location');

    Route::get('/edit-material-modal', function () {
        return view('inventory.edit_material_modal');
    })->name('edit.material.modal');

    // Vistas del flujo de Surtido
    Route::get('/pull-out-material', function () {
        return view('inventory.pull_out_material');
    })->name('pull.out.material');

    // Rutas de búsqueda
    Route::get('/search-stock', function () {
        return view('inventory.stock_view');
    })->name('SearchC');

    Route::get('/search-surtido', function () {
        return view('inventory.part_with_material');
    })->name('SearchS');

    // Rutas de acción (POST/PUT)
    Route::post('/select-material', function () {
        // Aquí iría la lógica para procesar los materiales seleccionados
        // y luego redirigir a la vista de salida de material.
        return redirect()->route('pull.out.material')->with('mensaje', 'Materiales seleccionados para surtir');
    })->name('Select_Material');

    Route::put('/exit-material', function () {
        return redirect()->back()->with('mensaje', 'Salida de material confirmada');
    })->name('Exist_Material');

    // ===== RUTAS DE ADMIN =====
  /*   Route::get('/reporte', function () {
        return view('reporte.index');
    })->name('reports'); */

    Route::get('/view-reports',[MaterialesController::class,'getAllMaterialesForReport'])->name('getReporte'); //ruta para obtener datos para el reporte


    Route::get('/workers', [getUsersController::class, 'index'])->name('workers');

    Route::get('/view-workers', [getUsersController::class, 'index'])->name('view_workers'); //ruta para consultar los trabajadores  

    // Formularios de gestión de trabajadores
    /* Route::get('/register-workers', function () {
        return view('workers.register');
    })->name('register_workers');



    
 */
    //ruta para mostrar en el formulario los almacenes y crear un nuevo trabajador
    Route::get('/register-workers', [AlmacenesController::class, 'showRegisterForm'])->name('getAlmacenes'); //ruta para obtener almacenes en el formulario de registro de trabajadores
    Route::get('/register-almacen', [AlmacenesController::class, 'index'])->name('getallAlmacenes'); //ruta para obtener almacenes en el formulario de registro de trabajadores
    Route::delete('/delete-warehouse/{id}', [AlmacenesController::class, 'detroyalmacen'])->name('deleteWarehouse'); //ruta para eliminar almacén
    Route::post('/create-warehouse', [AlmacenesController::class, 'createAlmacen'])->name('createWarehouse'); //ruta para crear almacén

    Route::get('/edit-workers/{id}', [createUserController::class, 'edit'])->name('edit_workers');

    // ===== RUTAS DE USUARIO =====
    Route::get('/user-profile', function () {
        return redirect()->route('profile.edit');
    })->name('user.profile');

    // ===== RUTAS DELETE USUARIO =====
    Route::delete('/delete-user/{id}', [createUserController::class, 'destroy'])->name('deleteUser'); // Controller para eliminar al usuario

    // ===== RUTAS DE ACCIONES (POST/PUT) - General =====
    Route::post('/register-user', function () {
        return redirect()->route('workers')->with('mensaje', 'Trabajador registrado exitosamente');
    })->name('Register_user');

    Route::post('/register-user',[createUserController::class, 'store'])->name('registerUser'); //controller para registrar al usuario

    Route::put('/update-user/{id}', [createUserController::class, 'update'])->name('updateUser');
});

// ===== RUTAS DE PERFIL DE BREEZE =====
Route::middleware('session.auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
