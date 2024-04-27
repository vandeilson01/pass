<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles

        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/3.19.5/swagger-ui.css" >

        <style>
            .scheme-container{
                display: none
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts

        <script src="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/3.19.5/swagger-ui-bundle.js"> </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/3.19.5/swagger-ui-standalone-preset.js"> </script>
        <script src="./openapi.js"> </script>
        <script>
            window.onload = function() {
                const ui = SwaggerUIBundle({
                spec: spec,
                dom_id: '#swagger-ui',
                deepLinking: true,
                presets: [
                    SwaggerUIBundle.presets.apis,
                    SwaggerUIStandalonePreset
                ],
                plugins: [
                    SwaggerUIBundle.plugins.DownloadUrl
                ],
                // layout: "StandaloneLayout"
                })
            
                window.ui = ui
            }
        </script>

        <script>
            var spec = {
            "openapi": "3.0.1",
            // "info": {
            //     "version": "1.0.0",
            //     "title": "API Specification Example"
            // },
             
            "paths": {
                "/user": {
                "get": {
                    "summary": "",
                    "operationId": "user",
                    "tags": [
                    "User"
                    ],
                    "requestBody": {
                    "content": {
                        "application/json": {
                        
                        }
                    }
                    },
                },
                },

                "/payment/return/{gateway:slug}": {
                "post": {
                    "summary": "",
                    "operationId": "paymentReturn",
                    "tags": [
                    "Payment"
                    ],
                    "requestBody": {
                    "content": {
                        "application/json": {
                        
                        }
                    }
                    },
                },
                },

                "/payment/deposit/add-credit": {
                "post": {
                    "summary": "",
                    "operationId": "paymentReturn",
                    "tags": [
                    "Payment"
                    ],
                    "requestBody": {
                    "content": {
                        "application/json": {
                        
                        }
                    }
                    },
                },
                },

                "/payment/cashout/request-cashout": {
                "post": {
                    "summary": "",
                    "operationId": "paymentReturn",
                    "tags": [
                    "Payment"
                    ],
                    "requestBody": {
                    "content": {
                        "application/json": {
                        
                        }
                    }
                    },
                },
                },

                "/wallet/get-balance": {
                "get": {
                    "summary": "",
                    "operationId": "wallet",
                    "tags": [
                    "Wallet"
                    ],
                    "requestBody": {
                    "content": {
                        "application/json": {
                        
                        }
                    }
                    },
                },
                },

                "/wallet/bonus": {
                "get": {
                    "summary": "",
                    "operationId": "wallet",
                    "tags": [
                    "Wallet"
                    ],
                    "requestBody": {
                    "content": {
                        "application/json": {
                        
                        }
                    }
                    },
                },
                },

                "/wallet/get-wallets": {
                "get": {
                    "summary": "",
                    "operationId": "wallet",
                    "tags": [
                    "Wallet"
                    ],
                    "requestBody": {
                    "content": {
                        "application/json": {
                        
                        }
                    }
                    },
                },
                },

                "/transactions": {
                "get": {
                    "summary": "",
                    "operationId": "transactions",
                    "tags": [
                    "Wallet"
                    ],
                    "requestBody": {
                    "content": {
                        "application/json": {
                        
                        }
                    }
                    },
                },
                },

                "/affiliate/get-statistics": {
                "get": {
                    "summary": "",
                    "operationId": "affiliate",
                    "tags": [
                    "Affiliate"
                    ],
                    "requestBody": {
                    "content": {
                        "application/json": {
                        
                        }
                    }
                    },
                },
                },


                "/games/crash": {
                "get": {
                    "summary": "",
                    "operationId": "gamesCrash",
                    "tags": [
                    "GamesCrash"
                    ],
                    "requestBody": {
                    "content": {
                        "application/json": {
                        
                        }
                    }
                    },
                },
                },

                "/games/create-fake-bets": {
                "post": {
                    "summary": "",
                    "operationId": "games",
                    "tags": [
                    "Games"
                    ],
                    "requestBody": {
                    "content": {
                        "application/json": {
                        
                        }
                    }
                    },
                },
                },


                "/games/create-fake-cashout": {
                "post": {
                    "summary": "",
                    "operationId": "games",
                    "tags": [
                    "Games"
                    ],
                    "requestBody": {
                    "content": {
                        "application/json": {
                        
                        }
                    }
                    },
                },
                },


                "/games/double": {
                "get": {
                    "summary": "",
                    "operationId": "gamesDouble",
                    "tags": [
                    "GamesDouble"
                    ],
                    "requestBody": {
                    "content": {
                        "application/json": {
                        
                        }
                    }
                    },
                },
                },

                "/games/game-provider/{game:slug}": {
                "get": {
                    "summary": "",
                    "operationId": "games",
                    "tags": [
                    "Games"
                    ],
                    "requestBody": {
                    "content": {
                        "application/json": {
                        
                        }
                    }
                    },
                },
                },


                "/games/mines": {
                "get": {
                    "summary": "",
                    "operationId": "gamesMines",
                    "tags": [
                    "GamesMines"
                    ],
                    "requestBody": {
                    "content": {
                        "application/json": {
                        
                        }
                    }
                    },
                },
                },

                "/games/mines(start)": {
                "post": {
                    "summary": "",
                    "operationId": "gamesMines",
                    "tags": [
                    "GamesMines"
                    ],
                    "requestBody": {
                    "content": {
                        "application/json": {
                        
                        }
                    }
                    },
                },
                },

                "/games/mines/play": {
                "post": {
                    "summary": "",
                    "operationId": "gamesMines",
                    "tags": [
                    "GamesMines"
                    ],
                    "requestBody": {
                    "content": {
                        "application/json": {
                        
                        }
                    }
                    },
                },
                },

                "/games/mines/cashout": {
                "post": {
                    "summary": "",
                    "operationId": "gamesMines",
                    "tags": [
                    "GamesMines"
                    ],
                    "requestBody": {
                    "content": {
                        "application/json": {
                        
                        }
                    }
                    },
                },
                },

                "/games/crash(add-bet-game)": {
                "post": {
                    "summary": "",
                    "operationId": "gamesCrash",
                    "tags": [
                    "GamesCrash"
                    ],
                    "requestBody": {
                    "content": {
                        "application/json": {
                        
                        }
                    }
                    },
                },
                },

                "/games/crash/cashout": {
                "post": {
                    "summary": "",
                    "operationId": "gamesCrash",
                    "tags": [
                    "GamesCrash"
                    ],
                    "requestBody": {
                    "content": {
                        "application/json": {
                        
                        }
                    }
                    },
                },
                },

                "/games/double(add-bet-game)": {
                "post": {
                    "summary": "",
                    "operationId": "gamesDouble",
                    "tags": [
                    "GamesDouble"
                    ],
                    "requestBody": {
                    "content": {
                        "application/json": {
                        
                        }
                    }
                    },
                },
                },

                "/games/game-provider/start-game/{game:slug}(strt-game)": {
                "get": {
                    "summary": "",
                    "operationId": "games",
                    "tags": [
                    "Games"
                    ],
                    "requestBody": {
                    "content": {
                        "application/json": {
                        
                        }
                    }
                    },
                },
                },


                "/login": {
                "post": {
                    "summary": "",
                    "operationId": "user",
                    "tags": [
                    "User"
                    ],
                    "requestBody": {
                    "content": {
                        "application/json": {
                        
                        }
                    }
                    },
                },
                },

                "/register": {
                "post": {
                    "summary": "",
                    "operationId": "user",
                    "tags": [
                    "User"
                    ],
                    "requestBody": {
                    "content": {
                        "application/json": {
                        
                        }
                    }
                    },
                },
                },

                "/forgot-password": {
                "post": {
                    "summary": "",
                    "operationId": "user",
                    "tags": [
                    "User"
                    ],
                    "requestBody": {
                    "content": {
                        "application/json": {
                        
                        }
                    }
                    },
                },
                },

                "/reset-password": {
                "post": {
                    "summary": "",
                    "operationId": "user",
                    "tags": [
                    "User"
                    ],
                    "requestBody": {
                    "content": {
                        "application/json": {
                        
                        }
                    }
                    },
                },
                },

                "/me": {
                "post": {
                    "summary": "",
                    "operationId": "user",
                    "tags": [
                    "User"
                    ],
                    "requestBody": {
                    "content": {
                        "application/json": {
                        
                        }
                    }
                    },
                },
                },

                "/logout": {
                "post": {
                    "summary": "",
                    "operationId": "user",
                    "tags": [
                    "User"
                    ],
                    "requestBody": {
                    "content": {
                        "application/json": {
                        
                        }
                    }
                    },
                },
                },

                "/account/profile": {
                "get": {
                    "summary": "",
                    "operationId": "accountWa",
                    "tags": [
                        "Account"
                    ],
                    "requestBody": {
                    "content": {
                        "application/json": {
                        
                        }
                    }
                    },
                },
                },

                "/account/profile": {
                "put": {
                    "summary": "",
                    "operationId": "accountWb",
                    "tags": [
                        "Account"
                    ],
                    "requestBody": {
                    "content": {
                        "application/json": {
                        
                        }
                    }
                    },
                },
                },


                "/account/change-password": {
                "put": {
                    "summary": "",
                    "operationId": "accountWc",
                    "tags": [
                        "Account"
                    ],
                    "requestBody": {
                    "content": {
                        "application/json": {
                        
                        }
                    }
                    },
                },
                },
 

                "/articles": {
                "post": {
                    "summary": "Create an article.",
                    "operationId": "createArticle",
                    "tags": [
                    "Article API"
                    ],
                    "requestBody": {
                    "content": {
                        "application/json": {
                        "schema": {
                            "$ref": "#/components/schemas/Article"
                        }
                        }
                    }
                    },
                    "responses": {
                    "201": {
                        "description": "Success",
                        "content": {
                        "application/json": {
                            "schema": {
                            "$ref": "#/components/schemas/Article"
                            }
                        }
                        }
                    },
                    "400": {
                        "$ref": "#/components/responses/IllegalInput"
                    }
                    }
                },
                "get": {
                    "summary": "Get a list of articles",
                    "operationId": "listArticles",
                    "tags": [
                    "Article API"
                    ],
                    "parameters": [
                    {
                        "$ref": "#/components/parameters/Limit"
                    },
                    {
                        "$ref": "#/components/parameters/Offset"
                    }
                    ],
                    "responses": {
                    "200": {
                        "description": "Success",
                        "content": {
                        "application/json": {
                            "schema": {
                            "$ref": "#/components/schemas/ArticleList"
                            }
                        }
                        }
                    }
                    }
                }
                },
                "/articles/{id}": {
                "get": {
                    "summary": "Get an article.",
                    "operationId": "getArticle",
                    "tags": [
                    "Article API"
                    ],
                    "parameters": [
                    {
                        "$ref": "#/components/parameters/Id"
                    }
                    ],
                    "responses": {
                    "200": {
                        "description": "Success",
                        "content": {
                        "application/json": {
                            "schema": {
                            "$ref": "#/components/schemas/Article"
                            }
                        }
                        }
                    },
                    "404": {
                        "$ref": "#/components/responses/NotFound"
                    }
                    }
                },
                "put": {
                    "summary": "Update",
                    "operationId": "updateArticle",
                    "tags": [
                    "Article API"
                    ],
                    "parameters": [
                    {
                        "$ref": "#/components/parameters/Id"
                    }
                    ],
                    "requestBody": {
                    "content": {
                        "application/json": {
                        "schema": {
                            "$ref": "#/components/schemas/Article"
                        }
                        }
                    }
                    },
                    "responses": {
                    "200": {
                        "description": "Success",
                        "content": {
                        "application/json": {
                            "schema": {
                            "$ref": "#/components/schemas/Article"
                            }
                        }
                        }
                    },
                    "404": {
                        "$ref": "#/components/responses/NotFound"
                    }
                    }
                },
                "delete": {
                    "summary": "Delete an article.",
                    "operationId": "deleteArticle",
                    "tags": [
                    "Article API"
                    ],
                    "parameters": [
                    {
                        "$ref": "#/components/parameters/Id"
                    }
                    ],
                    "responses": {
                    "204": {
                        "description": "Success"
                    },
                    "404": {
                        "$ref": "#/components/responses/NotFound"
                    }
                    }
                }
                }
            },
            "components": {
                "schemas": {
                "Id": {
                    "description": "Resource ID",
                    "type": "integer",
                    "format": "int64",
                    "readOnly": true,
                    "example": 1
                },
                "ArticleForList": {
                    "properties": {
                    "id": {
                        "$ref": "#/components/schemas/Id"
                    },
                    "category": {
                        "description": "Category of an article",
                        "type": "string",
                        "example": "sports"
                    }
                    }
                },
                "Article": {
                    "allOf": [
                    {
                        "$ref": "#/components/schemas/ArticleForList"
                    }
                    ],
                    "required": [
                    "text"
                    ],
                    "properties": {
                    "text": {
                        "description": "Content of an article",
                        "type": "string",
                        "maxLength": 1024,
                        "example": "# Title\n\n## Head Line\n\nBody"
                    }
                    }
                },
                "ArticleList": {
                    "type": "array",
                    "items": {
                    "$ref": "#/components/schemas/ArticleForList"
                    }
                },
                "Error": {
                    "description": "<table>\n  <tr>\n    <th>Code</th>\n    <th>Description</th>\n  </tr>\n  <tr>\n    <td>illegal_input</td>\n    <td>The input is invalid.</td>\n  </tr>\n  <tr>\n    <td>not_found</td>\n    <td>The resource is not found.</td>\n  </tr>\n</table>\n",
                    "required": [
                    "code",
                    "message"
                    ],
                    "properties": {
                    "code": {
                        "type": "string",
                        "example": "illegal_input"
                    }
                    }
                }
                },
                "parameters": {
                "Id": {
                    "name": "id",
                    "in": "path",
                    "description": "Resource ID",
                    "required": true,
                    "schema": {
                    "$ref": "#/components/schemas/Id"
                    }
                },
                "Limit": {
                    "name": "limit",
                    "in": "query",
                    "description": "limit",
                    "required": false,
                    "schema": {
                    "type": "integer",
                    "minimum": 1,
                    "maximum": 100,
                    "default": 10,
                    "example": 10
                    }
                },
                "Offset": {
                    "name": "offset",
                    "in": "query",
                    "description": "offset",
                    "required": false,
                    "schema": {
                    "type": "integer",
                    "minimum": 0,
                    "default": 0,
                    "example": 10
                    }
                }
                },
                "responses": {
                "NotFound": {
                    "description": "The resource is not found.",
                    "content": {
                    "application/json": {
                        "schema": {
                        "$ref": "#/components/schemas/Error"
                        }
                    }
                    }
                },
                "IllegalInput": {
                    "description": "The input is invalid.",
                    "content": {
                    "application/json": {
                        "schema": {
                        "$ref": "#/components/schemas/Error"
                        }
                    }
                    }
                }
                }
            }
            }
        </script>

    </body>
</html>
