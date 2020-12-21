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

export function formatOrdersTableData (data) {
    let formattedData = data.reduce((accumulator, currentValue, currentIndex) => {
        let status = ''
        if ( currentValue.cells[2].data == 0) {
            status = 'Inicijuotas'
        } else if (currentValue.cells[2].data == 1) {
            status = 'Atšauktas'
        } else if (currentValue.cells[2].data == 2) {
            status = 'Apmokėtas'
        } else if (currentValue.cells[2].data == 3) {
            status = 'Įvykęs'
        }
        accumulator.push({
            id: currentValue.cells[0].data, 
            key: currentValue.cells[1].data,
            status: status,
            email: currentValue.cells[3].data,
            offer_name: currentValue.cells[4].data,
            price: currentValue.cells[5].data,
        })
        return accumulator
    }, [])

    return formattedData
}

export function formatCategoriesTableData (data) {
    let formattedData = data.reduce((accumulator, currentValue, currentIndex) => {
        accumulator.push({
            id: currentValue.cells[0].data, 
            name: currentValue.cells[1].data,
        })
        return accumulator
    }, [])

    return formattedData
}

export function formatUsersTableData (data) {
    let formattedData = data.reduce((accumulator, currentValue, currentIndex) => {
        let role = ''
        if ( currentValue.cells[3].data == 1 || currentValue.cells[3].data == false) {
            role = 'Klientas'
        } else if (currentValue.cells[3].data == 2) {
            role = 'Administratorius'
        } else if (currentValue.cells[3].data == 3) {
            role = 'Super-administratorius'
        } else {
            role = 'Rolė'
        }
        
        accumulator.push({
            id: currentValue.cells[0].data, 
            name: currentValue.cells[1].data,
            email: currentValue.cells[2].data, 
            role: role,
        })
        return accumulator
    }, [])

    return formattedData
}

export function formatForCsv (data) {
     let formattedData = data.reduce((accumulator, currentValue, currentIndex) => {
        let values = Object.values(currentValue)
        accumulator.push(values)
        return accumulator
    }, [])
    
    return formattedData
}

export function today () {
    let today = new Date().toISOString().slice(0, 10)
    return today
}