import React, {Component} from 'react';


class ItemPost extends Component {
    constructor(props) {
        super(props);
        const posts = this.props;

    }

    render() {
        console.log('in component', this.props.posts);
        if (this.props.posts !== null) {
            console.log('not null', this.props.posts.hits);
            return (
                <div>
                    <div>
                        {this.props.posts.hits.map((item) => <div>{item.state || ''}</div>)}
                    </div>
                    /*<div className="panel-body">
                        <p>Клиент: </p>
                        <p>Проект: поект 4</p>
                        <p>Стоимость: 46000.00</p>
                        <p>Комментарии: 4 ччетыре четыре </p>
                        <a href="/index.php?r=project%2Fview&amp;id=5">подробнее...</a>
                    </div>*/
                </div>
            )

        } else
        {
            return (<p>do not render</p>);
        }

    }
}

export default ItemPost;