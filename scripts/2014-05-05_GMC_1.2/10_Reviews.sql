UPDATE Reviews SET ReviewCategoryId = (Select ReviewCategoryID from ReviewCategories WHERE CODE = 'FILMS')
GO