import React, {Component} from 'react';
import {Link} from "react-router-dom";

class EventInfo extends Component{

    render() {
        return (
            <div className={"panel-body panel post post-panel"}>
                <h5>Событие</h5>
                <p>{this.props.eventInfo.message}</p>
                <p>Создано {this.props.eventInfo.created}</p>
                <p>Назначено на {this.props.eventInfo.assignment}</p>
                <nav>
                    <Link to={"/eventsView/" + this.props.eventInfo.id_event}> подробнее </Link>
                </nav>
            </div>
        );
    }

}

export default EventInfo;