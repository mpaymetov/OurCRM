import React, {Component} from 'react';

class EventInfo extends Component{

    render() {
        return (
            <div className={"panel-body"}>
                <h5>Событие</h5>
                <p>{this.props.eventInfo.message}</p>
                <p>Дата создания {this.props.eventInfo.created}</p>
                <p>Дата выполнения {this.props.eventInfo.assignment}</p>
            </div>
        );
    }

}

export default EventInfo;