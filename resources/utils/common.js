export const formatBook = (books) => {
  return books
    .map((item) =>
      item.libraries.length
        ? item.libraries.map((library, index) => ({
            ...item,
            authorName: item.author.name,
            authorGenre: item.author.genre,
            authorBirth: item.author.birthday,
            libraryName: library.name,
            libraryAddress: library.address,
            libraryId: library.id,
            duplicated: index > 0 ? true : false,
          }))
        : {
            ...item,
            authorName: item.author.name,
            authorGenre: item.author.genre,
            authorBirth: item.author.birthday,
            libraryName: '',
            libraryAddress: '',
            libraryId: '',
            duplicated: false,
          },
    )
    .flat()
}

export const formatDate = (date) => {
  var d = new Date(date),
    month = '' + (d.getMonth() + 1),
    day = '' + d.getDate(),
    year = d.getFullYear()

  if (month.length < 2) month = '0' + month
  if (day.length < 2) day = '0' + day

  return [year, month, day].join('-')
}
