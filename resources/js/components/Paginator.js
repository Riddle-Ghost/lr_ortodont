import React, { Component } from 'react';

export default class Paginator extends Component {
  constructor(props) {
    super(props);
  }

  render() {
    return (
      <div className="pagination">
        <div className="pagination__docs">
          Всего {this.props.itemType}: <span>{this.props.allItemsCount}</span>
        </div>
        <div className="pagination__pager">
          {
            this.props.currentPage !== 1 &&
            <div className="pagination__pager-prev">
              <a onClick={this.props.onClickPrevious} style={{cursor: 'pointer'}} title="Листать назад">
                <img src="/image/icon/arrow_left.svg" alt="icon"/>
              </a>
            </div>
          }
          <ul>
            <li>{this.props.currentPage}</li>
          </ul>
          {
            this.props.currentPage !== this.props.pagesCount &&
            <div className="pagination__pager-next">
              <a onClick={this.props.onClickNext} style={{ cursor: 'pointer' }} title="Листать вперёд">
                <img src="/image/icon/arrow_right.svg" alt="icon" />
              </a>
            </div>
          }
        </div>
        <div className="pagination__all_pages">
          Всего страниц: <span>{this.props.pagesCount}</span>
        </div>
      </div>
    );
  }
}