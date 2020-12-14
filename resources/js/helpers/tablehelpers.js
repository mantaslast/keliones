export function formatOffersTableData (data) {
    let formattedData = data.reduce((accumulator, currentValue, currentIndex) => {
        accumulator.push({
            id: currentValue.cells[0].data, 
            name: currentValue.cells[1].data,
            city: currentValue.cells[2].data,
            country: currentValue.cells[3].data,
            category_name: currentValue.cells[4].data,
            price: currentValue.cells[5].data,
        })
        return accumulator
    }, [])

    return formattedData
}