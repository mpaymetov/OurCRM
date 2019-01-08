import React, {Component} from 'react';


class ItemEvent extends Component {
    constructor(props) {
        super(props);
        this.state =
            {hits : this.props.items};
    }

    render() {
        console.log('in component', this.props);
        if (this.props.hits !== '') {
            console.log('not null', this.props.items);
            return (
                <div>
                    <div>
                        {this.props.items.map((hits) =>
                            <div className="panel-body post panel">
                                <div>{hits.id_event || ''}</div>
                            </div>
                        )}
                    </div>
                </div>
            )
        } else {
            return (<p>do not render</p>);
        }

    }
}

export default ItemEvent;