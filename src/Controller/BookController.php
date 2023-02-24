<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/books', name: 'books')]
class BookController
{
    #[Route('', methods: ['GET'])]
    public function index(): Response
    {
        $books = json_decode(file_get_contents(__DIR__ . '/../../data/books.json'), true);
        return new Response(json_encode($books), Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }

    #[Route('', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $books = json_decode(file_get_contents(__DIR__ . '/../../data/books.json'), true);
        $lastId = end($books)['id'];
        $data['id'] = $lastId + 1;
        $books[] = $data;

        file_put_contents(__DIR__ . '/../../data/books.json', json_encode($books));

        return new Response(json_encode($data), Response::HTTP_CREATED, ['Content-Type' => 'application/json']);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function read($id): Response
    {
        $books = json_decode(file_get_contents(__DIR__ . '/../../data/books.json'), true);
        foreach ($books as $book) {
            if ($book['id'] == $id) {
                return new Response(json_encode($book), Response::HTTP_OK, ['Content-Type' => 'application/json']);
            }
        }

        return new Response(json_encode(['error' => 'Book not found']), Response::HTTP_NOT_FOUND, ['Content-Type' => 'application/json']);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(Request $request, $id): Response
    {
        $data = json_decode($request->getContent(), true);

        $books = json_decode(file_get_contents(__DIR__ . '/../../data/books.json'), true);
        foreach ($books as &$book) {
            if ($book['id'] == $id) {
                $book['title'] = $data['title'];
                $book['author'] = $data['author'];
                $book['year'] = $data['year'];
                file_put_contents(__DIR__ . '/../../data/books.json', json_encode($books));
                return new Response(json_encode($book), Response::HTTP_OK, ['Content-Type' => 'application/json']);
            }
        }

        return new Response(json_encode(['error' => 'Book not found']), Response::HTTP_NOT_FOUND, ['Content-Type' => 'application/json']);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete($id): Response
    {
        $books = json_decode(file_get_contents(__DIR__ . '/../../data/books.json'), true);
        foreach ($books as $key => $book) {
            if ($book['id'] == $id) {
                unset($books[$key]);
                file_put_contents(__DIR__ . '/../../data/books.json', json_encode(array_values($books)));
                return new Response(null, Response::HTTP_NO_CONTENT);
            }
        }

        return new Response(json_encode(['error' => 'Book not found']), Response::HTTP_NOT_FOUND, ['Content-Type' => 'application/json']);
    }
}
