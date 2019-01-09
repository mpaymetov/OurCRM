import React, {Component} from 'react';
import ItemEvent from '../event/itemEvent.jsx';
import AddButton from '../button/addButton.jsx';

class EventInfo extends Component{

    render() {
        const info = {path: "#", buttonName: "Создать обытие"};

        return (
            <h1>События</h1>
            <AddButton buttonInfo = {info}/>
            <ItemEvent items = {eventInfo}/>


        );
    }
}


export default EventInfo;
