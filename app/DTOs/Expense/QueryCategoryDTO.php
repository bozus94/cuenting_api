<?php

namespace App\DTOs\expense;

use Illuminate\Http\Request;

/**
 *Sin propiedades declaradas.
 */

final class QueryCategoryDTO
{

  public function __construct(
    public readonly ?bool $active = null,
    public readonly ?string $q = null,
    public readonly string $sort = "name",
    public readonly string $direction = "asc",
    public readonly int $page = 1,
    public readonly int $perPage = 15
  ) {}

  public function fromRequest(Request $request): self
  {
    return new self(
      active: $request->boolean('active', null),
      q: $request->input('q', null),
      sort: $request->input('sort', 'name'),
      direction: $request->input('direction', 'asc'),
      page: (int) $request->input('page', 1),
      perPage: (int) $request->input('perPage', 15)
    );
  }
}
