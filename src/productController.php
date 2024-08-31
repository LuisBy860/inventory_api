<?php
namespace App\Controllers;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ProductController {
    private $products = [];

    public function getAllProducts(Request $request, Response $response, array $args) {
        $response->getBody()->write(json_encode($this->products));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getProduct(Request $request, Response $response, array $args) {
        $id = $args['id'];
        $product = $this->findProduct($id);
        if ($product) {
            $response->getBody()->write(json_encode($product));
            return $response->withHeader('Content-Type', 'application/json');
        }
        return $response->withStatus(404)->getBody()->write('Product not found');
    }

    public function createProduct(Request $request, Response $response, array $args) {
        $data = $request->getBody()->getContents();
        $parsedData = json_decode($data, true);
        $newProduct = [
            'id' => count($this->products) + 1,
            'name' => $parsedData['name'],
            'description' => $parsedData['description'],
            'price' => $parsedData['price'],
            'stock' => $parsedData['stock']
        ];
        $this->products[] = $newProduct;
        $response->getBody()->write(json_encode($newProduct));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }

    public function updateProduct(Request $request, Response $response, array $args) {
        $id = $args['id'];
        $data = $request->getBody()->getContents();
        $parsedData = json_decode($data, true);
        $product = $this->findProduct($id);
        if ($product) {
            $product['name'] = $parsedData['name'];
            $product['description'] = $parsedData['description'];
            $product['price'] = $parsedData['price'];
            $product['stock'] = $parsedData['stock'];
            $response->getBody()->write(json_encode($product));
            return $response->withHeader('Content-Type', 'application/json');
        }
        return $response->withStatus(404)->getBody()->write('Product not found');
    }

    public function deleteProduct(Request $request, Response $response, array $args) {
        $id = $args['id'];
        $index = array_search($id, array_column($this->products, 'id'));
        if ($index !== false) {
            array_splice($this->products, $index, 1);
            return $response->withStatus(204);
        }
        return $response->withStatus(404)->getBody()->write('Product not found');
    }

    private function findProduct($id) {
        foreach ($this->products as $product) {
            if ($product['id'] == $id) {
                return $product;
            }
        }
        return null;
    }
}
