<?php namespace Penguin\Ielts\Reports;

use Dashboard\Classes\ReportDataSourceBase;
use Dashboard\Classes\ReportDimension;
use Dashboard\Classes\ReportMetric;
use Dashboard\Classes\ReportFetchData;
use Dashboard\Classes\ReportDataQueryBuilder;
use Dashboard\Classes\ReportFetchDataResult;

class PaidCourseDataSource extends ReportDataSourceBase
{
    public function __construct()
    {

        /**
         * DIMENSION
         * Group by paid date
         */
        $this->registerDimension(
            new ReportDimension(
                'paid_date',
                'penguin_ielts_enrollments.paid_at',
                'Paid Date'
            )
        );

        /**
         * METRICS
         */
        $this->registerMetric(
            new ReportMetric(
                'total_revenue',
                'penguin_ielts_courses.price',
                'Total Revenue',
                ReportMetric::AGGREGATE_SUM
            )
        );

        $this->registerMetric(
            new ReportMetric(
                'paid_users',
                'penguin_ielts_enrollments.id',
                'Paid Users',
                ReportMetric::AGGREGATE_COUNT
            )
        );
    }

    protected function fetchData(ReportFetchData $request): ReportFetchDataResult
    {
        $builder = new ReportDataQueryBuilder(
            'penguin_ielts_enrollments',              // main table
            $request->dimension,
            $request->metrics,
            $request->orderRule,
            $request->dimensionFilters,
            $request->limit,
            $request->paginationParams,
            $request->groupInterval,
            $request->hideEmptyDimensionValues,
            $request->dateStart,
            $request->dateEnd,
            $request->startTimestamp,
            'penguin_ielts_enrollments.paid_at',      // date column
            null,
            $request->totalsOnly
        );

        /**
         * Configure metrics with a JOIN operation
         */
        $builder->onConfigureMetrics(function ($query, $dimension, $metrics) {
            $query->leftJoin('penguin_ielts_courses', function ($join) {
                $join->on('penguin_ielts_courses.id', '=', 'penguin_ielts_enrollments.course_id');
            });
        });

        /**
         * Configure the query to filter for paid enrollments
         */
        $builder->onConfigureQuery(function ($query) {
            $query->where('penguin_ielts_enrollments.payment_status', '=', 'paid');
        });

        return $builder->getFetchDataResult(
            $request->metricsConfiguration
        );
    }
}
