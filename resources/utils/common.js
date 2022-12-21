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

export const formatDate = (date) => {
  var d = new Date(date),
      month = '' + (d.getMonth() + 1),
      day = '' + d.getDate(),
      year = d.getFullYear();

  if (month.length < 2) 
      month = '0' + month;
  if (day.length < 2) 
      day = '0' + day;

  return [year, month, day].join('-');
}