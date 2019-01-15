import React, {Component} from 'react';
import EventInfo from './eventInfo.jsx';
import AddButton from '../button/addButton.jsx';

class ProjectEvent extends Component{

    render() {
        const info = {path: "/eventForm", buttonName: "Создать cобытие"};
        var eventInfo = <div>У проекта нет событий</div>;

        if(this.props.event.length != 0) {
            eventInfo = this.props.event.map(
                (item) => <EventInfo eventInfo={item}/>
            );
        }

        return (
            <div className={"col-md-6"}>
                <h1>События</h1>
                <div className={"event-info post-panel "}>{eventInfo}</div>
                <AddButton buttonInfo = {info}/>
            </div>


        );
    }
}


export default ProjectEvent;
