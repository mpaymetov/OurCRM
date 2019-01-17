import React, {Component} from 'react';
import {Link} from "react-router-dom";

class EventInfo extends Component{

    isActive(elem) {
        console.log("active", elem);
        if (elem === 1) {
            return ('checked');
        }
    }


    render() {
        return (
            <div className={"panel-body panel post post-panel"}>
                <form className="checkbox_right">
                    <p>Активно<input checked={this.isActive(this.props.eventInfo.is_active)} type="checkbox"
                                     id={this.props.eventInfo.id_event} className="status"/>
                    </p>
                </form>
                <p>{this.props.eventInfo.message}</p>
                <p>Создано:  {this.props.eventInfo.created}</p>
                <p>Назначено на:  {this.props.eventInfo.assignment}</p>
                <nav>
                    <Link to={"/eventsView/" + this.props.eventInfo.id_event}> подробнее </Link>
                </nav>
            </div>
        );
    }

}

export default EventInfo;