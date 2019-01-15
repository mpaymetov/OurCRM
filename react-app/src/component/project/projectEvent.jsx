import React, {Component} from 'react';
import AddButton from '../button/addButton.jsx';
import ItemEvent from "../event/itemEvent.jsx";
import EventInfo from './eventInfo.jsx'

class ProjectEvent extends Component {
    constructor(props) {
        super(props);
        this.state = {
            hits:
                {
                    items: this.props.event
                }
        };
    }

    render() {
        const info = {path: "/eventForm", buttonName: "Создать cобытие"};
        var eventInfo = <div>У проекта нет событий</div>;
        console.log("in project event", this.state);
        if(this.props.event.length !== 0) {
            eventInfo = this.props.event.map(
                (item) => <EventInfo eventInfo={item}/>
            );
        }

        return (
            <div className={"col-md-6"}>
                <h1>События</h1>
                <div className={"event-info post-panel "}>{eventInfo}</div>
                <AddButton buttonInfo={info}/>
            </div>


        );
    }
}


export default ProjectEvent;
