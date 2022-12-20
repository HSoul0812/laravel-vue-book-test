export const formatBook = (books) => {
  return books
    .map((item) =>
      item.libraries.map((library) => ({
        ...item,
        authorName: item.author.name,
        authorGenre: item.author.genre,
        authorBirth: item.author.birthday,
        libraryName: library.name,
        libraryAddress: library.address,
        libraryId: library.id,
      })),
    )
    .flat()
}
